<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\frontend\models\forms\VerifyEmailForm;
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
    public const TEMPLATE = '@views/auth/verify-email';



    /**
     * @var VerifyEmailForm
     */
    public VerifyEmailForm $verifyEmailForm;
}