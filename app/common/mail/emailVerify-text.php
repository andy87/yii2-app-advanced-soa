<?php

use yii\web\View;
use app\common\models\Identity;
use app\frontend\controllers\AuthController;

/**
 * @var View $this
 * @var Identity $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl([
    AuthController::getEndpoint(AuthController::ACTION_VERIFY_EMAIL),
    'token' => $user->verification_token
]);

?>

Привет <?= $user->username ?>,

Подтвердите свой адрес электронной почты:

<?= $verifyLink ?>
