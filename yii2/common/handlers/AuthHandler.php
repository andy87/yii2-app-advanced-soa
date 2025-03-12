<?php

namespace yii2\common\handlers;

use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\common\components\handlers\TemplateHandler;
use yii2\common\services\AuthService;

/**
 * @property-read AuthService $service
 */
class AuthHandler extends TemplateHandler
{
    use LazyLoadTrait;


    /** @var array */
    public array $lazyLoadConfig = [
        'service' => AuthService::class
    ];



    /**
     * @return void
     */
    public function processLogout(): void
    {
        $this->service->logout();
    }
}