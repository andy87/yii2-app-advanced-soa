<?php declare(strict_types=1);

namespace frontend\resources\auth;

use common\resources\TemplateResources;
use yii2\frontend\models\forms\ResetPasswordForm;

/**
 * < Frontend > `AuthResetPasswordResources`
 *
 * @package yii2\frontend\resources\auth
 *
 * @tag #resources #auth #reset #password
 */
class AuthResetPasswordResources extends TemplateResources
{
    /** @var string Шаблон */
    public const string TEMPLATE = '@app/views/auth/reset-password';

    /** @var ResetPasswordForm $resetPasswordForm */
    public ResetPasswordForm $resetPasswordForm;
}