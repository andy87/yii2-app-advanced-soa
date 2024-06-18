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
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #site #handler #contact #form
     */
    public function handlerContactForm(ContactForm $contactForm, array $data = []): bool
    {
        if ($contactForm->load($data)) {

            if ($contactForm->validate())
            {
                $adminEmail = Yii::$app->params['adminEmail'] ?? null;

                if ($adminEmail)
                {
                    return $this->sendEmailContactForm($contactForm);

                } else {

                    $this->runtimeLogError( 'Admin email `is not set` in params',
                        __METHOD__,
                        $contactForm,
                        [
                            'data' => $data,
                            'params' => Yii::$app->params,
                        ]
                    );
                }
            }
        }

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
    public function sendEmailContactForm(ContactForm $contactForm): bool
    {
        $emailConstructEmail = $contactForm->constructEmailDto();

        return EmailService::getInstance()->send($emailConstructEmail);
    }
}