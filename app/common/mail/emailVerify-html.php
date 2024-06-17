<?php

use app\common\models\Identity;
use yii\{ web\View, helpers\Html };

/**
 * @var View $this
 * @var Identity $user
 */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/verify-email', 'token' => $user->verification_token]);

?>

<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to verify your email:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
