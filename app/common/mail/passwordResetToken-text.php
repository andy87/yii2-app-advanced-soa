<?php

use yii\web\View;
use app\common\models\Identity;

/**
 * @var View $this
 * @var Identity $user
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset-password', 'token' => $user->password_reset_token]);

?>

Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
