<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\auth;

use yii2\common\components\viewModels\TemplateViewModel;
use yii2\frontend\models\forms\ResetPasswordForm;

/**
 * < Frontend > `AuthResetPasswordViewModels`
 *
 * @package yii2\frontend\viewModels\auth
 *
 * @tag #viewModel #auth #reset #password
 */
class AuthResetPasswordViewModel extends TemplateViewModel
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/auth/reset-password';

    /** @var ResetPasswordForm $resetPasswordForm */
    public ResetPasswordForm $resetPasswordForm;
}