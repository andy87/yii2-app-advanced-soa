<?php declare(strict_types=1);

namespace app\common\components\interfaces;

use app\common\models\dto\EmailMessageDto;

/**
 * < Common > `ModelEmailingInterface`
 *
 * @package app\common\components\interfaces
 */
interface ModelEmailingInterface
{
    public function constructEmailDto(): EmailMessageDto;
}