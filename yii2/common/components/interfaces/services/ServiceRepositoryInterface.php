<?php declare(strict_types=1);

namespace yii2\common\components\interfaces\services;

use yii2\common\components\base\repository\items\base\SourceRepository;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\services
 *
 * @tag: #abstract #common #interface #service #repository
 */
interface ServiceRepositoryInterface
{
    public function getRepository(string $repositoryClassName):SourceRepository;
}