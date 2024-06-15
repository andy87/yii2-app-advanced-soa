<?php declare(strict_types=1);

namespace app\frontend\tests\_support;

use frontend\tests\_generated;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void verify($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;


    /**
     * @param $message
     *
     * @return void
     */
    public function seeValidationError($message): void
    {
        $this->see($message, '.invalid-feedback');
    }

    public function dontSeeValidationError($message)
    {
        $this->dontSee($message, '.invalid-feedback');
    }
}
