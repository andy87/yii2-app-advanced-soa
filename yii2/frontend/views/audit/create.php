<?php

use yii\helpers\Html;
use yii2\common\models\audit\AuditOrder;

/** @var string|null $error */

$this->title = 'Создать аудит';
?>

<section class="block__audit">
    <div class="b_audit--head">
        <h1 class="b_audit--title">Создать аудит</h1>
    </div>

    <?php if ($error !== null): ?>
        <div class="b_audit--alert alert alert-danger"><?= Html::encode($error) ?></div>
    <?php endif; ?>

    <form class="b_audit--form" method="post">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

        <label class="b_audit--label" for="audit-domain">Домен или URL</label>
        <input class="b_audit--input form-control" id="audit-domain" name="domain" type="text" placeholder="example.ru" required>

        <label class="b_audit--label" for="audit-tariff">Тариф</label>
        <select class="b_audit--input form-select" id="audit-tariff" name="tariff">
            <option value="<?= AuditOrder::TARIFF_EXPRESS ?>">Экспресс</option>
            <option value="<?= AuditOrder::TARIFF_FULL ?>">Полный</option>
            <option value="<?= AuditOrder::TARIFF_IMPLEMENTATION ?>">Аудит + внедрение</option>
        </select>

        <label class="b_audit--label" for="audit-page-limit">Лимит страниц</label>
        <input class="b_audit--input form-control" id="audit-page-limit" name="page_limit" type="number" min="1" max="100" value="<?= (int)($_ENV['AUDIT_DEFAULT_PAGE_LIMIT'] ?? 20) ?>">

        <label class="b_audit--label" for="audit-notes">Комментарий</label>
        <textarea class="b_audit--input form-control" id="audit-notes" name="notes" rows="4"></textarea>

        <p class="b_audit--notice">Проверяются только публичные страницы. Формы не отправляются. Отчёт не является юридической, SEO или security-гарантией.</p>

        <button class="b_audit--button btn btn-primary" type="submit">Создать заказ</button>
    </form>
</section>
