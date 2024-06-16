<?php

use yii\web\View;
use app\common\models\Identity;

/**
 * @var View $this
 * @var Identity $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);

?>

Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
