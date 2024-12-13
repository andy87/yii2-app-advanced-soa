<?php declare(strict_types=1);

namespace yii2\common\components\interfaces;

use yii2\common\models\dto\EmailMessageDto;

/**
 * < Common > `ModelEmailingInterface`
 *
 * @package yii2\common\components\interfaces
 */
interface ModelEmailingInterface
{
    public function constructEmailDto(): EmailMessageDto;
}