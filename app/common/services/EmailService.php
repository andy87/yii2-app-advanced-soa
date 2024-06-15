<?php declare(strict_types=1);

namespace app\common\services;

use Yii;
use app\common\models\dto\EmailDto;
use app\common\components\core\BaseService;
use yii\mail\{MailerInterface, MessageInterface};

/**
 * < Common > `EmailService`
 *
 * @package app\common\services
 *
 * @tag #common #service #email
 */
class EmailService extends BaseService
{
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
     * @param EmailDto $email
     * @param array $compose
     *
     * @return bool
     *
     * @tag #common #service #email #send
     */
    public function send(EmailDto $email, array $compose = [] ): bool
    {
        $message = $this->constructMessage($email, $compose);

        if ($message->send()) {

            return true;

        } else {

            Yii::error(['Email was not sent', [
                'email' => $email,
                'compose' => $compose,
            ]]);

            return false;
        }
    }

    /**
     * @param EmailDto $email
     * @param array $compose
     *
     * @return MessageInterface
     *
     * @tag #common #service #email #construct
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