<?php declare(strict_types=1);

namespace app\frontend\services\controllers;

use app\common\components\core\BaseService;
use app\common\models\dto\EmailDto;
use app\common\services\EmailService;
use app\frontend\models\forms\ContactForm;
use Yii;
use yii\base\InvalidConfigException;

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
                $this->sendEmailContactForm($contactForm);
            }

            Yii::error(['Admin email is not set in params', ['params' => Yii::$app->params]]);
        }

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