<?php declare(strict_types=1);

namespace app\backend\tests;

use Codeception\{ Actor, Lib\Friend };

/**
 * < Backend > `FunctionalTester`
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
 */
class FunctionalTester extends Actor
{
    use _generated\FunctionalTesterActions;
   /**
    * Define custom actions here
    */
}
