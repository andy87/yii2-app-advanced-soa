<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\auth;

use yii2\common\components\viewModels\TemplateViewModel;
use yii2\frontend\models\forms\PasswordResetRequestForm;

/**
 * < Frontend > `AuthRequestPasswordResetViewModels`
 *
 * @package yii2\frontend\viewModels\auth
 *
 * @tag #viewModel #auth #request #password #reset
 */
class AuthRequestPasswordResetViewModel extends TemplateViewModel
{
    /** @var string  */
    public const TEMPLATE = '@app/views/auth/request-password-reset-token';

    /** @var PasswordResetRequestForm  */
    public PasswordResetRequestForm $passwordResetRequestForm;



    /**
     * AuthRequestPasswordResetViewModels constructor.
     *
     * @return void
     *
     * @tag #viewModel #constructor
     */
    public function __construct()
    {
        $this->passwordResetRequestForm = new PasswordResetRequestForm;
    }
}