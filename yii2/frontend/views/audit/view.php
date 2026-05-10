<?php

use yii\helpers\Html;
use yii2\common\models\audit\AuditOrder;

/** @var AuditOrder $order */

$this->title = 'Заказ #' . $order->id;
?>

<section class="block__audit">
    <div class="b_audit--head">
        <h1 class="b_audit--title">Заказ #<?= (int)$order->id ?></h1>
        <?= Html::a('К списку', ['index'], ['class' => 'b_audit--link btn btn-outline-secondary']) ?>
    </div>

    <article class="b_audit--card">
        <h2 class="b_audit--subtitle"><?= Html::encode($order->domain?->host) ?></h2>
        <p class="b_audit--text">URL: <?= Html::encode($order->domain?->normalized_url) ?></p>
        <p class="b_audit--text">Оплата: <?= Html::encode($order->payment_status) ?></p>
        <p class="b_audit--text">Workflow: <?= Html::encode($order->workflow_status) ?></p>
        <p class="b_audit--text">Лимит: <?= (int)$order->page_limit ?> страниц</p>
    </article>

    <h2 class="b_audit--header">Запуски</h2>
    <?php foreach ($order->runs as $run): ?>
        <article class="b_audit--card">
            <p class="b_audit--text">AuditRun #<?= (int)$run->id ?>: <?= Html::encode($run->status) ?>, страниц: <?= (int)$run->pages_scanned ?></p>
            <?php if ($run->error_message): ?>
                <p class="b_audit--text __danger"><?= Html::encode($run->error_message) ?></p>
            <?php endif; ?>
            <?php if ($run->report): ?>
                <?= Html::a('Открыть отчёт', ['report', 'id' => $run->report->id], ['class' => 'b_audit--link btn btn-primary']) ?>
                <?= Html::a('PDF', ['download', 'id' => $run->report->id], ['class' => 'b_audit--link btn btn-outline-secondary']) ?>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>
