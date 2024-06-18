<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ResetPasswordSendForm;

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
    public const TEMPLATE = '@app/views/auth/reset-password';

    /** @var ResetPasswordSendForm $resetPasswordForm */
    public ResetPasswordSendForm $resetPasswordForm;
}