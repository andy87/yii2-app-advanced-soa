<?php declare(strict_types=1);

namespace yii2\common\components\base\services\items\source;

use Yii;
use Exception;
use yii\base\BaseObject;
use yii2\common\components\system\Logger;
use yii2\common\components\interfaces\CatcherInterface;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @property CatcherInterface|Logger $logger
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceService extends BaseObject
{
    /** @var Logger|string Класс логгера */
    protected const CatcherInterface|string CLASS_LOGGER = Logger::class;



    /** @var CatcherInterface */
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
     * @return ?CatcherInterface
     *
     * @throws Exception
     */
    private function getLogger(): ?CatcherInterface
    {
        /** @var CatcherInterface $logger */
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