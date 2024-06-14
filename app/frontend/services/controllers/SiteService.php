<?php declare(strict_types=1);

namespace app\frontend\services\controllers;

use Yii;
use yii\base\InvalidConfigException;
use app\common\services\EmailService;
use app\frontend\models\forms\ContactForm;
use app\common\components\core\BaseService;

/**
 * Class `SiteService`
 *
 * @package app\frontend\services\controllers
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
     */
    public function handlerContactForm(ContactForm $contactForm, array $data): ?bool
    {
        if ($contactForm->load($data) && $contactForm->validate()) {
            $adminEmail = Yii::$app->params['adminEmail'] ?? null;

            if ($adminEmail){

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
     */
    public function sendEmailContactForm(ContactForm $contactForm): bool
    {
        $emailConstructEmail = $contactForm->constructEmail();

        return EmailService::getInstance()
            ->sendEmail($emailConstructEmail);
    }
}