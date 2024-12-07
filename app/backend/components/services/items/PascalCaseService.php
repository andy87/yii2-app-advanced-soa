<?php declare(strict_types=1);

namespace app\backend\components\services\items;

use app\backend\models\items\PascalCase;
use app\common\components\interfaces\CatcherInterface;
use app\backend\components\producers\items\PascalCaseProducer;
use app\backend\components\repository\items\PascalCaseRepository;
use app\backend\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Backend > Сервис для работы с сущностью `PascalCase`
 *
 * @property CatcherInterface $logger
 * @property PascalCaseProducer $producer
 * @property PascalCaseRepository $repository
 * @property PascalCaseDataProvider $dataProvider
 * @property ServiceSettings $settings
 *
 * @method PascalCase createModel(array $params)
 * @method PascalCase addModel(array $params)
 * @method bool modelUpdate(PascalCase $model, mixed $params)
 * @method PascalCase|null getModel(int $id)
 * @method PascalCase|null getOneActive(int $id)
 * @method array getAll(string|array $criteria = [])
 * @method array getAllActive(string|array $criteria = [])
 * @method null|int delete(PascalCase $model)
 *
 * @package app\backend\components\services\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseService extends \app\common\components\services\items\PascalCaseService
{
    // {{Boilerplate}}
}