<?php

use app\common\models\LoginForm;
use app\frontend\resources\auth\AuthLoginResources;
use yii\web\View;
use yii\bootstrap5\{Html,ActiveForm};

/**
 * @var View $this
 * @var ActiveForm $form
 * @var AuthLoginResources $R
 */

$loginForm = $R->loginForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($loginForm, LoginForm::ATTR_USERNAME)->textInput(['autofocus' => true]) ?>

                <?= $form->field($loginForm, LoginForm::ATTR_PASSWORD)->passwordInput() ?>

                <?= $form->field($loginForm, LoginForm::ATTR_REMEMBER_ME)->checkbox() ?>

                <div class="my-1 mx-0" style="color:#999;">
                    Если вы забыли пароль, вы можете <?= Html::a('сбросить его', $loginForm->getHrefRequestPasswordReset()) ?>.
                    <br>
                    Нужно новое письмо с подтверждением? <?= Html::a('Отправить повторно', $loginForm->getHrefResendVerificationEmail()) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>