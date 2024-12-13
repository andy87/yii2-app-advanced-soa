<?php

use yii\web\View;
use yii\helpers\Html;
use yii2\common\models\Identity;
use yii2\frontend\controllers\AuthController;

/**
 * @var View $this
 * @var Identity $user
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl([
    AuthController::getEndpoint(AuthController::ACTION_RESET_PASSWORD),
    'token' => $user->password_reset_token
]);

?>

<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Перейдите по ссылке ниже, чтобы сбросить пароль:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
