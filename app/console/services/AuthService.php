<?php declare(strict_types=1);

namespace app\console\services;

use Yii;
use app\common\components\core\BaseService;

/**
 * < Frontend > `AuthService`
 *
 * @package app\console\services
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