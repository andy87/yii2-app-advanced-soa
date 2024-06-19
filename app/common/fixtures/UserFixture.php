<?php declare(strict_types=1);

namespace app\common\fixtures;

use yii\test\ActiveFixture;

/**
 * < Common >
 *     User fixture.
 *
 * @package app\common\fixtures
 *
 * @tag #fixtures #user
 */
class UserFixture extends ActiveFixture
{
    /** @var string  */
    public $modelClass = 'app\common\models\Identity';
}
