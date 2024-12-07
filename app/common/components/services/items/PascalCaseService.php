<?php declare(strict_types=1);

namespace app\common\components\services\items;

use app\common\models\items\PascalCase;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\base\services\items\BaseService;
use app\common\components\producers\items\PascalCaseProducer;
use app\common\components\repository\items\PascalCaseRepository;
use app\common\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Common > Родительский класс для сервисов: console/frontend/backend
 *
 * @property CatcherInterface $logger
 * @property PascalCaseProducer $producer
 * @property PascalCaseRepository $repository
 * @property PascalCaseDataProvider $dataProvider
 * @property ServiceSettings $settings
 *
 * @method PascalCase modelCreate(array $params)
 * @method PascalCase addModel(array $params)
 * @method bool modelUpdate(PascalCase $model, mixed $params)
 * @method PascalCase|null getOne(int $id)
 * @method PascalCase|null getOneActive(int $id)
 * @method array getAll(string|array $criteria = [])
 * @method array getAllActive(string|array $criteria = [])
 * @method null|int delete(PascalCase $model)
 *
 * @package app\common\components\services\items
 *
 * @tag: #boilerplate #common #service #{{snake_case}}
 */
class PascalCaseService extends BaseService
{
    // {{Boilerplate}}
}