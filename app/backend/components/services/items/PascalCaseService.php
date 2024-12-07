<?php declare(strict_types=1);

namespace app\backend\components\services\items;

use app\backend\models\items\PascalCase;
use app\backend\models\forms\items\PascalCaseForm;
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
 * @package app\backend\components\services\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseService extends \app\common\components\services\items\PascalCaseService
{
    // {{Boilerplate}}
}