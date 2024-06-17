<?php

/**
 * @var yii\web\View$this
 * @var yii\bootstrap5\ActiveForm $form
 * @var AuthResendVerificationEmailResources $R
 */

use yii\bootstrap5\{ Html, ActiveForm };
use app\frontend\resources\auth\AuthResendVerificationEmailResources;

$this->title = 'Resend verification email';
$this->params['breadcrumbs'][] = $this->title;

$resendVerificationEmailForm = $R->resendVerificationEmailForm;

?>

<div class="auth-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, введите ваш email. Письмо с подтверждением будет отправлено на него.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $resendVerificationEmailForm::ID]); ?>

            <?= $form
                ->field($resendVerificationEmailForm, $resendVerificationEmailForm::ATTR_EMAIL)
                ->textInput(['autofocus' => true])
            ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
