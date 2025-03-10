<?php declare(strict_types=1);

namespace yii2\common\services;

use andy87\lazy_load\yii2\LazyLoadTrait;
use Yii;
use yii2\common\models\dto\EmailMessageDto;
use yii2\common\components\core\BaseService;
use yii\mail\{MailerInterface, MessageInterface};

/**
 * < Common > `EmailService`
 *
 * @package yii2\common\services
 *
 * @tag #common #service #email
 */
class EmailService extends BaseService
{
    use LazyLoadTrait;

    /** @var MailerInterface $mailer */
    public MailerInterface $mailer;

    /**
     * @return array
     *
     * @tag #common #service #email #config
     */
    public static function getConfig(): array
    {
        return [
            'class' => static::class,
            'mailer' => Yii::$app->mailer,
        ];
    }

    /**
     * @param EmailMessageDto $emailMessageDto
     *
     * @return bool
     *
     * @tag #common #service #email #send
     */
    public function send(EmailMessageDto $emailMessageDto): bool
    {
        $message = $this->constructMessage($emailMessageDto);

        if ($message->send()) {

            return true;
        }

        Yii::error(['Email was not sent', [
            'emailMessageDto' => $emailMessageDto,
        ]]);

        return false;
    }

    /**
     * @param EmailMessageDto $emailMessageDto
     *
     * @return MessageInterface
     *
     * @tag #common #service #email #construct
     */
    public function constructMessage(EmailMessageDto $emailMessageDto): MessageInterface
    {
        $compose = $this->mailer->compose( $emailMessageDto->view, $emailMessageDto->params );

        if ($emailMessageDto->to) $compose->setTo($emailMessageDto->to);

        if ($emailMessageDto->fromEmail && $emailMessageDto->fromName){
            $compose->setFrom([$emailMessageDto->fromEmail => $emailMessageDto->fromName]);
        }

        if ( $emailMessageDto->ReplyToEmail && $emailMessageDto->ReplyToName ){
            $compose->setReplyTo([$emailMessageDto->ReplyToEmail => $emailMessageDto->ReplyToName]);
        }

        if ($emailMessageDto->subject) $compose->setSubject($emailMessageDto->subject);

        if ($emailMessageDto->body) $compose->setTextBody($emailMessageDto->body);

        return $compose;
    }
}