<?php

use yii\web\View;
use yii2\common\components\Auth;
use yii2\common\models\Identity;
use yii2\frontend\controllers\AuthController;

/**
 * @var View $this
 * @var Identity $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl([
    AuthController::getEndpoint(Auth::ACTION_VERIFY_EMAIL),
    'token' => $user->verification_token
]);

?>

Привет <?= $user->username ?>,

Подтвердите свой адрес электронной почты:

<?= $verifyLink ?>
