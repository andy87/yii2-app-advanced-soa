<?php declare(strict_types=1);

namespace yii2\common\components\services\items;

use yii2\common\models\items\PascalCase;
use yii2\common\models\forms\items\PascalCaseForm;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\producers\items\PascalCaseProducer;
use yii2\common\components\repository\items\PascalCaseRepository;
use yii2\common\components\dataProviders\items\PascalCaseDataProvider;
use yii2\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Common > Родительский класс для сервисов: console/frontend/backend
 *
 * @property CatcherInterface $logger
 * @property PascalCaseProducer $producer
 * @property PascalCaseRepository $repository
 * @property PascalCaseDataProvider $dataProvider
 * @property \yii2\common\components\base\services\items\settings\ServiceSettings $settings
 *
 * @method \yii2\common\models\items\PascalCase[] getList(int $page, int $perPage)
 * @method PascalCase|null getModel(int $id)
 * @method \yii2\common\models\items\PascalCase createModel(array $params)
 * @method \yii2\common\models\items\PascalCase|null addModel(array $params)
 * @method \yii2\common\models\items\PascalCase|null updateModel(\yii2\common\models\items\PascalCase $model, mixed $params)
 * @method \yii2\common\models\forms\items\PascalCaseForm|null getForm(int $id)
 * @method \yii2\common\models\forms\items\PascalCaseForm createForm(array $params)
 * @method \yii2\common\models\forms\items\PascalCaseForm|null addForm(array $params)
 * @method \yii2\common\models\forms\items\PascalCaseForm|null updateForm(\yii2\common\models\forms\items\PascalCaseForm $form, mixed $params)
 * @method \yii2\common\models\items\PascalCase|null getActiveModel(int $id)
 * @method \yii2\common\models\forms\items\PascalCaseForm|null getActiveForm(int $id)
 * @method array getAllModels(string|array $criteria = [])
 * @method \yii2\common\models\forms\items\PascalCaseForm[] getAllForms(string|array $criteria = [])
 * @method \yii2\common\models\items\PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method \yii2\common\models\forms\items\PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
 * @method int delete(\yii2\common\models\items\PascalCase $model)
 *
 * @package app\common\components\services\items
 *
 * @tag: #boilerplate #common #service #{{snake_case}}
 */
class PascalCaseService extends BaseService
{
    // {{Boilerplate}}
}