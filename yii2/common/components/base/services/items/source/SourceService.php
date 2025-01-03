<?php declare(strict_types=1);

namespace common\components\base\services\items\source;

use Yii;
use Exception;
use yii\base\BaseObject;
use common\components\system\Logger;
use common\interfaces\CatcherInterface;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @property CatcherInterface|Logger $logger
 *
 * @package yii2\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceService extends BaseObject
{
    /** @var Logger|string Класс логгера */
    protected const CatcherInterface|string CLASS_LOGGER = Logger::class;



    /** @var \common\interfaces\CatcherInterface */
    protected CatcherInterface $logger;



    /**
     * @param array $config
     *
     * @throws Exception
     */
    public function __construct( array $config = [])
    {
        parent::__construct($config);

        $this->setupLogger();
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function setupLogger(): void
    {
        $this->logger = $this->getLogger();
    }

    /**
     * @return ?\common\interfaces\CatcherInterface
     *
     * @throws Exception
     */
    private function getLogger(): ?CatcherInterface
    {
        /** @var \common\interfaces\CatcherInterface $logger */
        $logger = Yii::createObject([
            'class' => static::CLASS_LOGGER
        ]);

        return $logger;
    }

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $data
     *
     * @return bool
     *
     * @throws Exception
     */
    public function prepareException( Exception $e, string $method, string $message, array $data = [] ): bool
    {
        return $this->logger->logCatch( ...func_get_args() );
    }
}