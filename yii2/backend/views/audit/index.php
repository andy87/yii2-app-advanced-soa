<?php

use yii\helpers\Html;
use yii2\common\models\audit\AuditOrder;

/** @var AuditOrder[] $orders */

$this->title = 'Аудиты';
?>

<section class="block__audit">
    <div class="b_audit--head">
        <h1 class="b_audit--title">Аудиты</h1>
    </div>

    <?php foreach ($orders as $order): ?>
        <article class="b_audit--card">
            <h2 class="b_audit--subtitle">#<?= (int)$order->id ?> <?= Html::encode($order->domain?->host) ?></h2>
            <p class="b_audit--text">Клиент: <?= Html::encode($order->user?->email) ?></p>
            <p class="b_audit--text">Оплата: <?= Html::encode($order->payment_status) ?>; workflow: <?= Html::encode($order->workflow_status) ?></p>
            <?= Html::a('Открыть', ['view', 'id' => $order->id], ['class' => 'b_audit--link btn btn-outline-secondary']) ?>
        </article>
    <?php endforeach; ?>
</section>
