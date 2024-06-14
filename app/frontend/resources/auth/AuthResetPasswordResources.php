<?php

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ResetPasswordForm;

/**
 * Class `AuthResetPasswordResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #reset #password
 */
class AuthResetPasswordResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = 'auth/reset-password';

    public ResetPasswordForm $resetPasswordForm;
}