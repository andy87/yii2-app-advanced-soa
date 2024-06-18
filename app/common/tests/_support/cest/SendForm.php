<?php

namespace app\common\tests\cest;

use app\common\components\forms\BaseWebForm;
use app\frontend\{controllers\AuthController, tests\FunctionalTester};

/**
 * < Frontend > `SendForm`
 *
 * @package app\frontend\tests\cest
 *
 *
 * @tag #frontend #tests #cest #SendForm
 */
abstract class SendForm
{
    /** @var BaseWebForm|string $classNnameFprm */
    protected const BASE_FORM_CLASS = BaseWebForm::class;

    /** @var BaseWebForm $form */
    protected BaseWebForm $form;

    /** @var string $formName */
    protected string $formName;

    /** @var string $formId */
    protected string $formId;

    /**
     * @endpoint auth/signup
     *
     * @param FunctionalTester $I
     *
     * @return void
     *
     * @see AuthController::actionSignup()
     *
     * @tag #frontend #tests #functional #SignupCest #_before
     */
    public function _before(FunctionalTester $I): void
    {
        $this->form = new (static::BASE_FORM_CLASS)();

        $this->formId = $this->getFormId();

        $this->formName = $this->getFormName();
    }

    /**
     * @return string
     *
     * @tag #getter #formName
     */
    protected function getFormId(): string
    {
        return '#' . $this->form->id;
    }

    /**
     * @return string
     *
     * @tag #getter #formName
     */
    protected function getFormName(): string
    {
        $parts = explode('\\', get_class($this->form));

        return array_pop($parts);
    }
}