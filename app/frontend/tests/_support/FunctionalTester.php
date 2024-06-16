<?php declare(strict_types=1);

namespace app\frontend\tests;

use Codeception\{ Actor, Lib\Friend };

/**
 * < Frontend > `FunctionalTester`
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
 * @tag #frontend #tests #FunctionalTester
 */
class FunctionalTester extends Actor
{
    use _generated\FunctionalTesterActions;


    /**
     * @param $message
     *
     * @return void
     *
     * @tag #frontend #tests #functional #seeValidationError
     */
    public function seeValidationError($message): void
    {
        $this->see($message, '.invalid-feedback');
    }

    /**
     * @param $message
     *
     * @return void
     *
     * @tag #frontend #tests #functional #seeValidationError
     */
    public function dontSeeValidationError($message): void
    {
        $this->dontSee($message, '.invalid-feedback');
    }
}
