<?php declare(strict_types=1);

namespace common\models\forms;

use common;
use common\models\dto\EmailMessageDto;
use common\interfaces\ModelEmailingInterface;
use common\components\base\models\forms\BaseWebForm;

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