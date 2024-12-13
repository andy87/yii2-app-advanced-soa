<?php declare(strict_types=1);

namespace yii2\common\fixtures;

use yii\test\ActiveFixture;

/**
 * < Common >
 *     User fixture.
 *
 * @package yii2\common\fixtures
 *
 * @tag #fixtures #user
 */
class UserFixture extends ActiveFixture
{
    /** @var string  */
    public $modelClass = 'yii2\common\models\Identity';
}
