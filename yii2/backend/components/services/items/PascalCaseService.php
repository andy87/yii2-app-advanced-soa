<?php declare(strict_types=1);

namespace yii2\backend\components\services\items;

use yii2\backend\models\items\PascalCase;
use yii2\backend\models\forms\items\PascalCaseForm;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\backend\components\producers\items\PascalCaseProducer;
use yii2\backend\components\repository\items\PascalCaseRepository;
use yii2\backend\components\dataProviders\items\PascalCaseDataProvider;
use yii2\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Backend > Сервис для работы с сущностью `PascalCase`
 *
 * @property CatcherInterface $logger
 * @property \yii2\backend\components\producers\items\PascalCaseProducer $producer
 * @property \yii2\backend\components\repository\items\PascalCaseRepository $repository
 * @property \yii2\backend\components\dataProviders\items\PascalCaseDataProvider $dataProvider
 * @property ServiceSettings $settings
 *
 * @method \yii2\backend\models\items\PascalCase[] getList(int $page, int $perPage)
 * @method \yii2\backend\models\items\PascalCase|null getModel(int $id)
 * @method PascalCase createModel(array $params)
 * @method PascalCase|null addModel(array $params)
 * @method \yii2\backend\models\items\PascalCase|null updateModel(PascalCase $model, mixed $params)
 * @method \yii2\backend\models\forms\items\PascalCaseForm|null getForm(int $id)
 * @method \yii2\backend\models\forms\items\PascalCaseForm createForm(array $params)
 * @method \yii2\backend\models\forms\items\PascalCaseForm|null addForm(array $params)
 * @method \yii2\backend\models\forms\items\PascalCaseForm|null updateForm(\yii2\backend\models\forms\items\PascalCaseForm $form, mixed $params)
 * @method PascalCase|null getActiveModel(int $id)
 * @method \yii2\backend\models\forms\items\PascalCaseForm|null getActiveForm(int $id)
 * @method array getAllModels(string|array $criteria = [])
 * @method \yii2\backend\models\forms\items\PascalCaseForm[] getAllForms(string|array $criteria = [])
 * @method PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method \yii2\backend\models\forms\items\PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
 * @method int delete(\yii2\backend\models\items\PascalCase $model)
 *
 * @package app\backend\components\services\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseService extends \yii2\common\components\services\items\PascalCaseService
{
    // {{Boilerplate}}
}