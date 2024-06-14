<?php

namespace app\common\services;

use Yii;
use app\common\models\dto\EmailDto;
use app\common\components\core\BaseService;
use yii\mail\{MailerInterface, MessageInterface};

/**
 * Class `EmailService`
 *
 * @package app\common\services
 *
 */
class EmailService extends BaseService
{
    /** @var MailerInterface $mailer */
    public MailerInterface $mailer;

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return [
            'class' => static::class,
            'mailer' => Yii::$app->mailer,
        ];
    }

    /**
     * @param EmailDto $email
     * @param array $compose
     *
     * @return bool
     */
    public function sendEmail( EmailDto $email, array $compose = [] ): bool
    {
        $result = $this
            ->constructMessage($email, $compose)
            ->send();

        if ($result) return true;

        Yii::error(['Email was not sent', [
            'email' => $email,
            'compose' => $compose,
        ]]);

        return false;
    }

    /**
     * @param EmailDto $email
     * @param array $compose
     *
     * @return MessageInterface
     */
    public function constructMessage( EmailDto $email, array $compose = [] ): MessageInterface
    {
        $compose = $this->mailer->compose( ...$compose );

        if ($email->to) $compose->setTo($email->to);

        if ($email->fromEmail && $email->fromName){
            $compose->setFrom([$email->fromEmail => $email->fromName]);
        }

        if ( $email->ReplyToEmail && $email->ReplyToName ){
            $compose->setReplyTo([$email->ReplyToEmail => $email->ReplyToName]);
        }

        if ($email->subject) $compose->setSubject($email->subject);

        if ($email->body) $compose->setTextBody($email->body);

        return $compose;
    }
}