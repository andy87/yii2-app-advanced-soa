<?php declare(strict_types=1);

namespace yii2\common\components\base\services\items\source;

use Yii;
use Exception;
use yii\base\BaseObject;
use yii2\common\components\system\Logger;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\common\components\base\producers\items\source\SourceProducer;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceService extends BaseObject
{
    /** @var Logger|string Класс логгера */
    protected const Logger|string CLASS_LOGGER = Logger::class;



    /** @var CatcherInterface */
    protected CatcherInterface $logger;



    /**
     * @throws Exception
     */
    public function init(): void
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
    public function catcher( Exception $e, string $method, string $message, array $data ): bool
    {
        return $this->logger->logCatch( ...func_get_args() );
    }
}