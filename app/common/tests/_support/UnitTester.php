<?php declare(strict_types=1);

namespace app\common\tests\_support;

use Codeception\Lib\Friend;
use common\tests\_generated;

/**
 * < Common > `UnitTester`
 *
 *      Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void verify($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 *
 * @tag #common #tests #support #unitTester
 */
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;
   /**
    * Define custom actions here
    */
}
