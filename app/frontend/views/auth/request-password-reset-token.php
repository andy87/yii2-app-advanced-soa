<?php

use yii\web\View;
use yii\bootstrap5\{ Html, ActiveForm };
use app\frontend\resources\auth\AuthRequestPasswordResetResources;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var AuthRequestPasswordResetResources $R
 */

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;

$passwordResetRequestForm = $R->passwordResetRequestForm

?>

<div class="auth-request-password-reset" <?=$this->attrDataTemplate(__FILE__)?>>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, введите ваш email. Ссылка для сброса пароля будет отправлена на него.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $passwordResetRequestForm->id]); ?>

                <?= $form->field($passwordResetRequestForm, $passwordResetRequestForm::ATTR_EMAIL)
                    ->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
