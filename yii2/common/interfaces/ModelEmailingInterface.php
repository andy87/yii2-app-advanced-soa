<?php declare(strict_types=1);

namespace common\interfaces;

use common\models\dto\EmailMessageDto;

/**
 * < Common > `ModelEmailingInterface`
 *
 * @package yii2\common\components\interfaces
 */
interface ModelEmailingInterface
{
    public function constructEmailDto(): EmailMessageDto;
}