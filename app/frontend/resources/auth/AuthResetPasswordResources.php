<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ResetPasswordForm;

/**
 * < Frontend > `AuthResetPasswordResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #reset #password
 */
class AuthResetPasswordResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@views/auth/reset-password';

    /** @var ResetPasswordForm $resetPasswordForm */
    public ResetPasswordForm $resetPasswordForm;
}