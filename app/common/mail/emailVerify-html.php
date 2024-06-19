<?php

use app\common\models\Identity;
use app\frontend\controllers\AuthController;
use yii\{ web\View, helpers\Html };

/**
 * @var View $this
 * @var Identity $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl([
    AuthController::getEndpoint(AuthController::ACTION_VERIFY_EMAIL),
    'token' => $user->verification_token
]);

?>

<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Перейдите по ссылке ниже, чтобы подтвердить свой адрес электронной почты:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
