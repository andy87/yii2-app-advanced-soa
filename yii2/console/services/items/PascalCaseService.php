<?php declare(strict_types=1);

namespace console\services\items;

use common\components\base\services\items\settings\ServiceSettings;
use common\interfaces\CatcherInterface;
use console\models\forms\items\PascalCaseForm;
use console\models\items\PascalCase;
use console\repository\items\PascalCaseRepository;

/**
 * < Console > Сервис для работы с сущностью `PascalCase`
 *
 * @property \common\interfaces\CatcherInterface $logger
 * @property \console\producers\items\PascalCaseProducer $producer
 * @property PascalCaseRepository $repository
 * @property \console\dataProviders\items\PascalCaseDataProvider $dataProvider
 * @property ServiceSettings $settings
 *
 * @method PascalCase[] getList(int $page, int $perPage)
 * @method PascalCase|null getModel(int $id)
 * @method PascalCase createModel(array $params)
 * @method PascalCase|null addModel(array $params)
 * @method PascalCase|null updateModel(PascalCase $model, mixed $params)
 * @method PascalCaseForm|null getForm(int $id)
 * @method PascalCaseForm createForm(array $params)
 * @method PascalCaseForm|null addForm(array $params)
 * @method PascalCaseForm|null updateForm(PascalCaseForm $form, mixed $params)
 * @method PascalCase|null getActiveModel(int $id)
 * @method PascalCaseForm|null getActiveForm(int $id)
 * @method array getAllModels(string|array $criteria = [])
 * @method PascalCaseForm[] getAllForms(string|array $criteria = [])
 * @method \console\models\items\PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
 * @method int delete(\yii2\console\models\items\PascalCase $model)
 *
 * @package yii2\console\components\services\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseService extends \common\services\items\PascalCaseService
{
    // {{Boilerplate}}
}