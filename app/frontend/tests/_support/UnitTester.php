<?php declare(strict_types=1);

namespace app\frontend\tests;

use Codeception\Actor;
use Codeception\Lib\Friend;
use yii\mail\MessageInterface;

/**
 * < Frontend > `UnitTester`
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
 * @method void seeEmailIsSent()
 * @method MessageInterface grabLastSentEmail()
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends Actor
{
    use _generated\UnitTesterActions;
   /**
    * Define custom actions here
    */
}
