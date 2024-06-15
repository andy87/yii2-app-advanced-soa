<?php declare(strict_types=1);

namespace app\common\models\dto;

use Yii;

/**
 * < Common > `Mail`
 *
 * @package app\common\components\mail
 */
class EmailDto
{
    public ?string $to = null;
    public ?string $fromEmail = null;
    public ?string $fromName = null;

    public ?string $ReplyToName = null;
    public ?string $ReplyToEmail = null;
    public ?string $subject = null;
    public ?string $body = null;
    public ?string $verifyCode = null;

    /**
     *
     */
    public function __construct()
    {
        $this->fromEmail = Yii::$app->params['senderEmail'];
        $this->fromName = Yii::$app->params['senderName'];
    }
}