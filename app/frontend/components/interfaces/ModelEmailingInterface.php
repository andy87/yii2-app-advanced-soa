<?php declare(strict_types=1);

namespace app\frontend\components\interfaces;

use app\common\models\dto\EmailDto;

/**
 * Interface `ModelEmailingInterface`
 *
 * @package app\frontend\components\interfaces
 */
interface ModelEmailingInterface
{
    public function constructEmailDto(): EmailDto;

    public function getEmailComposeConfig(array $params): array;
}