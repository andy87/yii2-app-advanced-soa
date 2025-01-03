<?php declare(strict_types=1);

namespace frontend\services;

use common\services\EmailService;
use JsonException;
use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\base\services\items\SingletonService;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\common\components\system\Logger;
use yii2\frontend\models\forms\ContactForm;

/**
 * < Frontend > `SiteService`
 *
 * @property CatcherInterface|Logger $logger
 *
 * @package yii2\frontend\services\controllers
 *
 * @tag #services #site
 */
class SiteService extends SingletonService
{
    /**
     * @param ContactForm $contactForm
     *
     * @return bool
     *
     * @throws InvalidConfigException|JsonException
     *
     * @tag #site #handler #contact #form
     */
    public function sendContactFormToAdminEmail( ContactForm $contactForm ): bool
    {
        $contactForm->email = Yii::$app->params['adminEmail'] ?? null;

        if ($contactForm->email)
        {
            return $this->sendEmailByContactForm($contactForm);
        }

        $this->logger->logError(__METHOD__,'Admin email `is not set` in params', [
            '$contactForm' => [
                'attributes' => $contactForm->attributes,
                'errors' => $contactForm->errors,
            ]
        ]);

        return false;
    }

    /**
     * @param ContactForm $contactForm
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #site #send #email #contact #form
     */
    public function sendEmailByContactForm(ContactForm $contactForm): bool
    {
        $emailConstructEmail = $contactForm->constructEmailDto();

        return EmailService::getInstance()->send($emailConstructEmail);
    }
}