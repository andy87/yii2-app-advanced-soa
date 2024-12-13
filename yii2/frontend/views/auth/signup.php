<?php

use yii\web\View;
use yii\bootstrap5\{ Html, ActiveForm };
use yii2\frontend\resources\auth\AuthSignupResources;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var AuthSignupResources $R
 */

$signupForm = $R->signupForm;

$this->title = $signupForm::TITLE;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="auth-signup" <?=$this->attrDataTemplate(__FILE__)?>>
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=$signupForm::HINT;?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $signupForm->id]); ?>

                <?= $form->field($signupForm, $signupForm::ATTR_USERNAME)->textInput(['autofocus' => true]) ?>

                <?= $form->field($signupForm, $signupForm::ATTR_EMAIL) ?>

                <?= $form->field($signupForm, $signupForm::ATTR_PASSWORD)->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton($signupForm::BUTTON_SIGNUP, [
                        'class' => 'btn btn-primary',
                        'name' => 'signup-button'
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
