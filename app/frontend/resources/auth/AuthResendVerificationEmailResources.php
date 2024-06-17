<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ResendVerificationEmailForm;

/**
 * < Frontend > `AuthResendVerificationEmailResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #resend #verification #email
 */
class AuthResendVerificationEmailResources extends TemplateResources
{
    /** @var string  */
    public const TEMPLATE = '@app/views/auth/resend-verification-email';



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