<?php declare(strict_types=1);

namespace common\fixtures;

use yii\test\ActiveFixture;
use common\models\Identity;

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