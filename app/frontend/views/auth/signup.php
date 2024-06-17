<?php

use yii\web\View;
use yii\bootstrap5\{ Html, ActiveForm };
use app\frontend\resources\auth\AuthSignupResources;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var AuthSignupResources $R
 */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

$signupForm = $R->signupForm;

?>

<div class="auth-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $signupForm::ID]); ?>

                <?= $form->field($signupForm, $signupForm::ATTR_USERNAME)->textInput(['autofocus' => true]) ?>

                <?= $form->field($signupForm, $signupForm::ATTR_EMAIL) ?>

                <?= $form->field($signupForm, $signupForm::ATTR_PASSWORD)->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
