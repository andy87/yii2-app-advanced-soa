<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\auth;

use yii2\common\components\viewModels\TemplateViewModel;
use yii2\frontend\models\forms\ResendVerificationEmailForm;

/**
 * < Frontend > `AuthResendVerificationEmailViewModels`
 *
 * @package yii2\frontend\viewModels\auth
 *
 * @tag #viewModel #auth #resend #verification #email
 */
class AuthResendVerificationEmailViewModel extends TemplateViewModel
{
    /** @var string  */
    public const TEMPLATE = '@app/views/auth/resend-verification-email';



    public ResendVerificationEmailForm $resendVerificationEmailForm;



    /**
     * @return void
     *
     * @tag #viewModel #constructor
     */
    public function __construct()
    {
        $this->resendVerificationEmailForm = new ResendVerificationEmailForm;
    }
}