<?php declare(strict_types=1);

namespace common\services\items;

use common\dataProviders\items\PascalCaseDataProvider;
use common\producers\items\PascalCaseProducer;
use common\repository\items\PascalCaseRepository;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\common\models\forms\items\PascalCaseForm;
use yii2\common\models\items\PascalCase;

/**
 * < Common > Родительский класс для сервисов: console/frontend/backend
 *
 * @property CatcherInterface $logger
 * @property \common\producers\items\PascalCaseProducer $producer
 * @property \common\repository\items\PascalCaseRepository $repository
 * @property PascalCaseDataProvider $dataProvider
 * @property \yii2\common\components\base\services\items\settings\ServiceSettings $settings
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
 * @method PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
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