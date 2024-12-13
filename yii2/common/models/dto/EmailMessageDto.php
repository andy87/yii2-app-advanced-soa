<?php declare(strict_types=1);

namespace yii2\common\models\dto;

use Yii;

/**
 * < Common > `Mail`
 *
 * @package yii2\common\components\mail
 */
class EmailMessageDto
{
    public ?string $to = null;
    public ?string $fromEmail = null;
    public ?string $fromName = null;

    public ?string $ReplyToName = null;
    public ?string $ReplyToEmail = null;
    public ?string $subject = null;
    public ?string $body = null;
    public ?string $verifyCode = null;


    /** @var ?array compose view argument */
    public ?array $view = null;

    /** @var array compose params argument  */
    public array $params = [];

    /**
     *
     */
    public function __construct()
    {
        $this->fromEmail = Yii::$app->params['senderEmail'];
        $this->fromName = Yii::$app->params['senderName'];
    }
}