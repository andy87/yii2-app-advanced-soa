<?php declare(strict_types=1);

namespace yii2\console\services;

use Yii;
use yii2\common\components\core\BaseService;

/**
 * < Console > `AuthService`
 *
 * @package yii2\console\services
 *
 * @tag #services #auth
 */
class AuthService extends BaseService
{
    /**
     * @return bool
     *
     * @tag #service #auth #logout
     */
    public function logout(): bool
    {
        return Yii::$app->user->logout();
    }

}