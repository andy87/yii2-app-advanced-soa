<?php

use app\common\models\forms\LoginForm;
use app\frontend\resources\auth\AuthLoginResources;
use yii\bootstrap5\{ActiveForm, Html};
use yii\web\View;

/**
 * @var View $this
 * @var ActiveForm $form
 * @var AuthLoginResources $R
 */

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;

$loginForm = $R->loginForm;

?>

<div class="auth-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $loginForm::ID]); ?>

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
