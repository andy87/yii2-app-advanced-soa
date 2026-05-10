<?php

use yii\helpers\Html;
use yii2\common\models\audit\AuditOrder;

/** @var AuditOrder[] $orders */

$this->title = 'Мои аудиты';
?>

<section class="block__audit">
    <div class="b_audit--head">
        <h1 class="b_audit--title">Мои аудиты</h1>
        <?= Html::a('Создать аудит', ['create'], ['class' => 'b_audit--button btn btn-primary']) ?>
    </div>

    <div class="b_audit--list">
        <?php foreach ($orders as $order): ?>
            <article class="b_audit--card">
                <div class="b_audit--body">
                    <h2 class="b_audit--subtitle"><?= Html::encode($order->domain?->host) ?></h2>
                    <p class="b_audit--text">Оплата: <?= Html::encode($order->payment_status) ?>; статус: <?= Html::encode($order->workflow_status) ?></p>
                    <p class="b_audit--text">Лимит страниц: <?= (int)$order->page_limit ?></p>
                    <?= Html::a('Открыть', ['view', 'id' => $order->id], ['class' => 'b_audit--link btn btn-outline-secondary']) ?>
                </div>
            </article>
        <?php endforeach; ?>

        <?php if ($orders === []): ?>
            <p class="b_audit--text __muted">Заказов пока нет.</p>
        <?php endif; ?>
    </div>
</section>
