<?php declare(strict_types=1);

namespace yii2\frontend\tests\unit\models;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use yii\base\InvalidConfigException;
use yii\mail\{MailerInterface, MessageInterface};
use yii2\frontend\{models\forms\ContactForm, services\controllers\SiteService, tests\UnitTester};

/**
 * < Frontend > `ContactFormTest`
 *
 * @property-read SiteService $siteService
 *
 * @property UnitTester $tester
 *
 * @package yii2\frontend\tests\unit\models
 *
 * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ContactFormTest
 *
 * @originalFile https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ContactFormTest.php
 *
 * @tag #tests #unit #models #ContactFormTest
 */
class ContactFormTest extends Unit
{
    use LazyLoadTrait;

    public array $lazyLoadConfig = [
        'siteService' => SiteService::class
    ];

    /**
     * Send email
     *
     * @cli ./vendor/bin/codecept run yii2/frontend/tests/unit/models/ContactFormTest:testSendEmail
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/unit/models/ContactFormTest.php#L10
     *
     * @return void
     *
     * @throws InvalidConfigException|MailerInterface|ModuleException
     *
     * @tag #frontend #tests #unit #models #ContactFormTest #testSendEmail
     */
    public function testSendEmail(): void
    {
        $contactForm = new ContactForm();

        $contactForm->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        $sendResult = $this->siteService->sendEmailContactForm($contactForm);

        verify( $sendResult )->notEmpty();

        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();

        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('admin@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('noreply@example.com');
        verify($emailMessage->getReplyTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getSubject())->equals('very important letter subject');
        verify($emailMessage->toString())->stringContainsString('body of current message');
    }
}
