<?php

use yii\helpers\Html;
use yii2\common\models\audit\AuditOrder;
use yii2\common\models\audit\Report;

/** @var AuditOrder $order */

$this->title = 'Аудит #' . $order->id;
?>

<section class="block__audit">
    <div class="b_audit--head">
        <h1 class="b_audit--title">Аудит #<?= (int)$order->id ?></h1>
        <?= Html::a('К списку', ['index'], ['class' => 'b_audit--link btn btn-outline-secondary']) ?>
    </div>

    <article class="b_audit--card">
        <h2 class="b_audit--subtitle"><?= Html::encode($order->domain?->host) ?></h2>
        <p class="b_audit--text">Клиент: <?= Html::encode($order->user?->email) ?></p>
        <p class="b_audit--text">Оплата: <?= Html::encode($order->payment_status) ?></p>
        <p class="b_audit--text">Workflow: <?= Html::encode($order->workflow_status) ?></p>
        <?= Html::a('Отметить paid', ['mark-paid', 'id' => $order->id], ['class' => 'b_audit--button btn btn-success', 'data-method' => 'post']) ?>
        <?= Html::a('Запустить аудит', ['run', 'id' => $order->id], ['class' => 'b_audit--button btn btn-primary', 'data-method' => 'post']) ?>
    </article>

    <h2 class="b_audit--header">Запуски</h2>
    <?php foreach ($order->runs as $run): ?>
        <article class="b_audit--card">
            <p class="b_audit--text">Run #<?= (int)$run->id ?>: <?= Html::encode($run->status) ?>; страниц: <?= (int)$run->pages_scanned ?></p>
            <?php if ($run->error_message): ?>
                <p class="b_audit--text __danger"><?= Html::encode($run->error_message) ?></p>
            <?php endif; ?>
            <?php if ($run->report instanceof Report): ?>
                <p class="b_audit--text">Отчёт: <?= Html::encode($run->report->status) ?></p>
                <?php if ($run->report->html_path): ?>
                    <p class="b_audit--text">HTML: <?= Html::encode($run->report->html_path) ?></p>
                <?php endif; ?>
                <?= Html::a('Утвердить отчёт', ['approve-report', 'id' => $run->report->id], ['class' => 'b_audit--button btn btn-success', 'data-method' => 'post']) ?>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>
