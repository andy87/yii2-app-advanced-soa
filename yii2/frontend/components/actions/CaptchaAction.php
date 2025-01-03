<?php declare(strict_types=1);

namespace frontend\components\actions;

/**
 * < Frontend > `Captcha`
 *
 * @package yii2\frontend\components
 *
 * @tag #components #actions #captcha
 */
class CaptchaAction extends \yii\captcha\CaptchaAction
{
    /** @var string  */
    public const string TEST_VALUE = 'test_me';



    /**
     * @return ?string
     */
    public static function getFixedVerifyCode(): ?string
    {
        return YII_ENV_TEST ? self::TEST_VALUE : null;
    }
}