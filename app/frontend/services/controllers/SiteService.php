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

            if ($adminEmail) {
                $email = $this->constructEmail($contactForm);

                return $this->sendEmail($email);
            }

            Yii::error(['Admin email is not set in params', ['params' => Yii::$app->params]]);
        }

        return null;
    }

    /**
     * @param ContactForm $contactForm
     *
     * @return EmailDto
     */
    public function constructEmail(ContactForm $contactForm): EmailDto
    {
        $emailDto = new EmailDto();

        $emailDto->to = $contactForm->email;
        $emailDto->fromEmail = Yii::$app->params['senderEmail'];
        $emailDto->fromName = Yii::$app->params['senderName'];
        $emailDto->ReplyToEmail = $contactForm->email;
        $emailDto->ReplyToName = $contactForm->name;
        $emailDto->subject = $contactForm->subject;
        $emailDto->body = $contactForm->body;

        return $emailDto;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param EmailDto $email
     *
     * @return bool whether the email was sent
     *
     * @throws InvalidConfigException
     */
    public function sendEmail(EmailDto $email): bool
    {
        $result = EmailService::getInstance()
            ->sendEmail($email);

        if ($result) return true;

        Yii::error(['Email was not sent', $email]);

        return false;
    }
}