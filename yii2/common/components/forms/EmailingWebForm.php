<?php declare(strict_types=1);

namespace yii2\common\components\forms;

use yii2\common\{components\interfaces\ModelEmailingInterface, models\dto\EmailMessageDto};

/**
 * < Common > `EmailingModel`
 *
 * @package yii2\common\components\model
 */
abstract class EmailingWebForm extends BaseWebForm implements ModelEmailingInterface
{
    /** @var array  */
    protected array $messageConfig = [];
    protected array $messageParams = [];



    /**
     * @return EmailMessageDto
     */
    abstract public function constructEmailDto(): EmailMessageDto;
}