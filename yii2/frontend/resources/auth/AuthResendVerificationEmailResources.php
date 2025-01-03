<?php declare(strict_types=1);

namespace frontend\resources\auth;

use common\resources\TemplateResources;
use frontend\models\forms\ResendVerificationEmailForm;

/**
 * < Frontend > `AuthResendVerificationEmailResources`
 *
 * @package yii2\frontend\resources\auth
 *
 * @tag #resources #auth #resend #verification #email
 */
class AuthResendVerificationEmailResources extends TemplateResources
{
    /** @var string  */
    public const string TEMPLATE = '@app/views/auth/resend-verification-email';



    public ResendVerificationEmailForm $resendVerificationEmailForm;



    /**
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct()
    {
        $this->resendVerificationEmailForm = new ResendVerificationEmailForm;
    }
}