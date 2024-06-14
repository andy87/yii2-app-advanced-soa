<?php

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\ResendVerificationEmailForm;

/**
 * Class `AuthResendVerificationEmailResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #resend #verification #email
 */
class AuthResendVerificationEmailResources extends TemplateResources
{
    /** @var string  */
    public const TEMPLATE = '@views/auth/resend-verification-email';



    public ResendVerificationEmailForm $resendVerificationEmailForm;



    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->resendVerificationEmailForm = new ResendVerificationEmailForm;
    }
}