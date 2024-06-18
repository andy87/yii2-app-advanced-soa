<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\frontend\models\forms\VerifyEmailSendForm;
use app\common\components\resources\TemplateResources;

/**
 * < Frontend > `AuthVerifyEmailResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #verify #email
 */
class AuthVerifyEmailResources extends TemplateResources
{
    /** @var string  */
    public const TEMPLATE = '@app/views/auth/verify-email';



    /**
     * @var VerifyEmailSendForm
     */
    public VerifyEmailSendForm $verifyEmailForm;
}