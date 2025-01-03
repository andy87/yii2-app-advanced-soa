<?php declare(strict_types=1);

namespace common\interfaces\services;

use common\components\base\repository\items\base\SourceRepository;

/**
 * < Common >
 *
 * @package yii2\common\components\interfaces\services
 *
 * @tag: #abstract #common #interface #service #repository
 */
interface ServiceRepositoryInterface
{
    public function getRepository(string $repositoryClassName):SourceRepository;
}