<?php

use yii2\frontend\controllers\AuthController;
use yii\web\View;
use yii2\common\models\Identity;

/**
 * @var View $this
 * @var Identity $user
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl([
    AuthController::getEndpoint(AuthController::ACTION_RESET_PASSWORD),
    'token' => $user->password_reset_token
]);

?>

Привет <?= $user->username ?>,

Подтвердите свой адрес электронной почты:

<?= $resetLink ?>
