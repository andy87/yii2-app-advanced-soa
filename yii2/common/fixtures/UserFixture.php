<?php declare(strict_types=1);

namespace yii2\common\fixtures;

use yii\test\ActiveFixture;
use yii2\common\models\Identity;

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
    public $modelClass = Identity::class;
}