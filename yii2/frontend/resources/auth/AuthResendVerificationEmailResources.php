<?php declare(strict_types=1);

namespace yii2\frontend\resources\auth;

use yii2\common\components\resources\TemplateResources;
use yii2\frontend\models\forms\ResendVerificationEmailForm;

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