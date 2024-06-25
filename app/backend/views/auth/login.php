<?php

use yii\web\View;
use app\common\components\Action;
use yii\bootstrap5\{ Html, ActiveForm };
use app\backend\controllers\AuthController;
use app\backend\resources\auth\AuthLoginResources;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var AuthLoginResources $R
 */

$this->title = AuthController::LABELS[Action::LOGIN];

$loginForm = $R->loginForm;

?>

<div class="site-login" <?=$this->attrDataTemplate(__FILE__)?>>
    <div class="mt-5 offset-lg-3 col-lg-6">
        <h1><?= Html::encode($this->title) ?></h1>

        <p><?= $loginForm::HINT ?></p>

        <?php $form = ActiveForm::begin(['id' => $loginForm->id]); ?>

            <?= $form->field($loginForm, $loginForm::ATTR_USERNAME)->textInput(['autofocus' => true]) ?>

            <?= $form->field($loginForm, $loginForm::ATTR_PASSWORD)->passwordInput() ?>

            <?= $form->field($loginForm, $loginForm::ATTR_REMEMBER_ME)->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton($loginForm::BUTTON_LOGIN_TEXT, ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
