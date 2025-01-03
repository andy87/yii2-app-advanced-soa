<?php

use frontend\resources\auth\AuthResetPasswordResources;
use yii\bootstrap5\{ActiveForm, Html};

/**
 * @var yii\web\View $this
 * @var \frontend\resources\auth\AuthResetPasswordResources $R
 */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;

$resetPasswordForm = $R->resetPasswordForm;

?>

<div class="auth-reset-password" <?=$this->attrDataTemplate(__FILE__)?>>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, выберите новый пароль:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $resetPasswordForm->id]); ?>

                <?= $form->field($resetPasswordForm, $resetPasswordForm::ATTR_PASSWORD)->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
