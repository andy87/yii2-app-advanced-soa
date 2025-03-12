<?php declare(strict_types=1);

namespace yii2\frontend\services\controllers;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Yii;
use yii\base\InvalidConfigException;
use yii2\common\{components\core\BaseService, services\EmailService};
use yii2\frontend\models\forms\ContactForm;

/**
 * < Frontend > `SiteService`
 *
 * @property-read EmailService $emailService
 *
 * @package yii2\frontend\services\controllers
 *
 * @tag #services #site
 */
class SiteService extends BaseService
{
    use LazyLoadTrait;

    /**
     * @param string $name
     *
     * @return array|string|null
     */
    protected function findLazyLoadConfig(string $name): array|string|null
    {
        $config = [
            'emailService' => EmailService::getConfig()
        ];

        return $config[$name] ?? null;
    }

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
                if (Yii::$app->params['adminEmail'] ?? false)
                {
                    return $this->sendEmailContactForm($contactForm);

                } else {

                    $this->addLogError( 'Admin email `is not set` in params',
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

        return $this->emailService->send($emailConstructEmail);
    }
}