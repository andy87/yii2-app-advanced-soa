<?php

namespace yii2\common\components\base\services\items;

use yii\base\BaseObject;
use yii2\common\components\system\Logger;
use yii2\common\components\traits\SingletonTrait;

/**
 * < Common > Родительский абстрактный класс для Singleton сервисов
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base
 */
abstract class SingletonService extends SourceService
{
    use SingletonTrait;


    /** @var Logger $logger */
    protected Logger $logger;



    /**
     * @param array $config
     */
    public function __construct( array $config = [])
    {
        parent::__construct($config);

        $this->setupLogger();
    }

    /**
     * @return void
     */
    protected function setupLogger(): void
    {
        $this->logger = new Logger();
    }
}