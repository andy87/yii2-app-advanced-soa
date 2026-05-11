<?php declare(strict_types=1);

namespace yii2\console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use yii2\common\models\Identity;

/**
 * Консольные команды для локального dev-окружения.
 *
 * @package yii2\console\controllers
 */
final class DevController extends Controller
{
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_PASSWORD = 'Admin12345!';
    private const ADMIN_EMAIL = 'admin@example.local';

    /**
     * Создаёт или обновляет локального администратора для Docker dev-окружения.
     *
     * @return int Код завершения console-команды.
     * @throws \yii\base\Exception Если Yii security не сможет создать пароль или auth key.
     */
    public function actionCreateAdmin(): int
    {
        if (!YII_ENV_DEV) {
            $this->stderr("Команда доступна только в dev-окружении.\n");

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $admin = Identity::findOne([Identity::ATTR_USERNAME => self::ADMIN_USERNAME]);
        $isNewRecord = $admin === null;

        if ($admin === null) {
            $admin = new Identity();
            $admin->username = self::ADMIN_USERNAME;
            $admin->email = self::ADMIN_EMAIL;
            $admin->generateAuthKey();
        }

        $admin->status = Identity::STATUS_ACTIVE;
        $admin->role = Identity::ROLE_ADMIN;
        $admin->name = 'Local Admin';
        $admin->company_name = 'Site Auditor Local';
        $admin->setPassword(self::ADMIN_PASSWORD);

        if (!$admin->save()) {
            $this->stderr("Не удалось сохранить администратора:\n");
            foreach ($admin->getFirstErrors() as $attribute => $error) {
                $this->stderr("- {$attribute}: {$error}\n");
            }

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $action = $isNewRecord ? 'создан' : 'обновлён';
        $this->stdout("Локальный admin-пользователь {$action}.\n");
        $this->stdout("Username: " . self::ADMIN_USERNAME . "\n");
        $this->stdout("Password: " . self::ADMIN_PASSWORD . "\n");

        return ExitCode::OK;
    }
}
