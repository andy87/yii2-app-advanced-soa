<?php declare(strict_types=1);

namespace app\common\components\models;

use app\frontend\components\models\BaseWebForm;
use app\common\{ models\dto\EmailMessageDto, components\interfaces\ModelEmailingInterface };

/**
 * < Common > `EmailingModel`
 *
 * @package app\frontend\components\model
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