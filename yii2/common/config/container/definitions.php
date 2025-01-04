<?php declare(strict_types=1);

/**
 * < Common > Definitions для контейнера зависимостей
 *
 * @package yii2\backend\config\container
 */

return [
    yii\web\View::class => common\components\View::class,
    yii\widgets\LinkPager::class => yii\bootstrap5\LinkPager::class,
];