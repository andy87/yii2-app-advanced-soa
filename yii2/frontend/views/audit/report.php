<?php

use yii\helpers\Html;
use yii2\common\models\audit\Report;

/** @var Report $report */

$summary = $report->getJsonArray('summary_json');
$this->title = 'Отчёт #' . $report->id;
?>

<section class="block__report">
    <div class="b_report--head">
        <h1 class="b_report--title">Отчёт по сайту <?= Html::encode($report->run?->order?->domain?->host) ?></h1>
        <?= Html::a('Скачать PDF', ['download', 'id' => $report->id], ['class' => 'b_report--button btn btn-primary']) ?>
    </div>

    <div class="b_report--summary">
        <p class="b_report--text"><?= Html::encode((string)($summary['text'] ?? '')) ?></p>
        <p class="b_report--text">Критичных: <?= (int)($summary['critical'] ?? 0) ?>; средних: <?= (int)($summary['medium'] ?? 0) ?>; низких: <?= (int)($summary['low'] ?? 0) ?>.</p>
    </div>

    <h2 class="b_report--header">Задачи</h2>
    <?php foreach ($report->tasks as $task): ?>
        <article class="b_report--task">
            <h3 class="b_report--subtitle"><?= Html::encode($task->title) ?></h3>
            <p class="b_report--text">Приоритет: <?= Html::encode($task->priority) ?></p>
            <p class="b_report--text"><?= Html::encode($task->business_reason) ?></p>
            <p class="b_report--text"><strong>Что сделать:</strong> <?= Html::encode($task->suggested_action) ?></p>
        </article>
    <?php endforeach; ?>

    <p class="b_report--notice">AI-рекомендации требуют проверки человеком. Отчёт не обещает рост трафика, заявок или продаж.</p>
</section>
