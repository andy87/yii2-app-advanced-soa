<?php declare(strict_types=1);

namespace app\frontend\services;

use Yii;
use yii\base\InvalidConfigException;
use app\frontend\models\forms\ContactForm;
use app\common\{ services\EmailService, components\core\BaseService };

/**
 * < Frontend > `SiteService`
 *
 * @package app\frontend\services\controllers
 *
 * @tag #services #site
 */
class SiteService extends BaseService
{
    /**
     * @param ContactForm $contactForm
     *
     * @param array $data
     *
     * @return ?bool
     *
     * @throws InvalidConfigException
     *
     * @tag #site #handler #contact #form
     */
    public function handlerContactForm(ContactForm $contactForm, array $data): ?bool
    {
        if ($contactForm->load($data) && $contactForm->validate()) {
            $adminEmail = Yii::$app->params['adminEmail'] ?? null;

            if ($adminEmail)
            {
                return $this->sendEmailContactForm($contactForm);

            } else {

                $message = 'Admin email `is not set` in params';
            }

        } else {
            $message = 'Contact form `is not valid`';
        }

        $this->runtimeLogError(__METHOD__, $message, $contactForm);

        return null;
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
    public function sendEmailContactForm(ContactForm $contactForm): bool
    {
        $emailConstructEmail = $contactForm->constructEmailDto();

        return EmailService::getInstance()->send($emailConstructEmail);
    }
}