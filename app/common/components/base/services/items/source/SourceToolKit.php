<?php declare(strict_types=1);

namespace app\common\components\base\services\items\source;

use Yii;
use Exception;
use yii\base\BaseObject;
use app\common\components\system\Logger;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceToolKit extends BaseObject
{
    /** @var CatcherInterface */
    protected CatcherInterface $logger;

    /** @var ?SourceProducer */
    protected ?SourceProducer $_producer = null;

    /** @var ?SourceRepository */
    protected ?SourceRepository $_repository = null;

    /** @var ?SourceActiveDataProvider  */
    protected ?SourceActiveDataProvider $_dataProvider = null;



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
            'class' => Logger::class
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
    public function handlerCatch( Exception $e, string $method, string $message, array $data ): bool
    {
        return Logger::logCatch( ...func_get_args() );
    }
}