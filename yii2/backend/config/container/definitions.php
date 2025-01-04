<?php declare(strict_types=1);

/**
 * < Backend > Definitions для контейнера зависимостей
 *
 * @package yii2\backend\config\container
 */

return [
    \backend\services\items\PascalCaseService::class => static function () {
        return new \backend\services\items\PascalCaseService();
    },
];