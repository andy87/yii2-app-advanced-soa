<?php declare(strict_types=1);

namespace common\components\base\resources\items\sources;

use yii\base\BaseObject;

/**
 * < Common > Base class for all resources
 *
 * @package app\common\components\resources\source\base
 *
 * @tag: #abstract #common #resource #base #source
 */
abstract class SourceResource extends BaseObject
{
    /** @var string Key for the release method */
    public const string KEY = 'R';


    /**
     * @return array
     */
    public function release(): array
    {
        return [ static::KEY => $this ];
    }
}