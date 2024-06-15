<?php declare(strict_types=1);

namespace app\common\components\interfaces;

use app\common\models\dto\EmailDto;

/**
 * < Common > `ModelEmailingInterface`
 *
 * @package app\frontend\components\interfaces
 */
interface ModelEmailingInterface
{
    public function constructEmailDto(): EmailDto;

    public function getEmailComposeConfig(array $params): array;
}