<?php

/**
 * @var View $this
 * @var Identity $user
 */

use yii\web\View;
use app\common\models\Identity;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>

Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
