<?php declare(strict_types=1);

namespace app\common\components\forms;

use app\common\{components\interfaces\ModelEmailingInterface, models\dto\EmailMessageDto};

/**
 * < Common > `EmailingModel`
 *
 * @package app\common\components\model
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