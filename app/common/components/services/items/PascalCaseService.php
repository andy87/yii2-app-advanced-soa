<?php declare(strict_types=1);

namespace app\common\components\services\items;

use app\common\components\base\services\items\BaseService;
use app\common\components\base\services\items\settings\ServiceSettings;
use app\common\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\producers\items\PascalCaseProducer;
use app\common\components\repository\items\PascalCaseRepository;
use app\common\models\forms\items\PascalCaseForm;
use app\common\models\items\PascalCase;

/**
 * < Common > Родительский класс для сервисов: console/frontend/backend
 *
 * @property CatcherInterface $logger
 * @property PascalCaseProducer $producer
 * @property PascalCaseRepository $repository
 * @property PascalCaseDataProvider $dataProvider
 * @property ServiceSettings $settings
 *
 * @method PascalCase[] getList(int $page, int $perPage)
 * @method PascalCase createModel(array $params)
 * @method PascalCase|null addModel(array $params)
 * @method PascalCase|null updateModel(PascalCase $model, mixed $params)
 * @method PascalCaseForm createForm(array $params)
 * @method PascalCase|null addForm(array $params)
 * @method PascalCase|null updateForm(PascalCaseForm $form, mixed $params)
 * @method PascalCase|null getModel(int $id)
 * @method PascalCaseForm|null getForm(int $id)
 * @method PascalCase|null getOneActive(int $id)
 * @method array getAll(string|array $criteria = [])
 * @method array getAllActive(string|array $criteria = [])
 * @method int delete(PascalCase $model)
 *
 * @package app\common\components\services\items
 *
 * @tag: #boilerplate #common #service #{{snake_case}}
 */
class PascalCaseService extends BaseService
{
    // {{Boilerplate}}
}