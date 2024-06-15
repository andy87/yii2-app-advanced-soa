<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\VerifyEmailForm;

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