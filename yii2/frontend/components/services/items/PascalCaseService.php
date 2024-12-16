<?php declare(strict_types=1);

namespace yii2\frontend\components\services\items;

use yii2\frontend\models\items\PascalCase;
use yii2\frontend\models\forms\items\PascalCaseForm;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\frontend\components\producers\items\PascalCaseProducer;
use yii2\frontend\components\repository\items\PascalCaseRepository;
use yii2\frontend\components\dataProviders\items\PascalCaseDataProvider;
use yii2\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Frontend > Сервис для работы с сущностью `PascalCase`
 *
 * @property CatcherInterface $logger
 * @property \yii2\frontend\components\producers\items\PascalCaseProducer $producer
 * @property \yii2\frontend\components\repository\items\PascalCaseRepository $repository
 * @property \yii2\frontend\components\dataProviders\items\PascalCaseDataProvider $dataProvider
 * @property \yii2\common\components\base\services\items\settings\ServiceSettings $settings
 *
 * @method PascalCase[] getList(int $page, int $perPage)
 * @method PascalCase|null getModel(int $id)
 * @method PascalCase createModel(array $params)
 * @method PascalCase|null addModel(array $params)
 * @method PascalCase|null updateModel(\yii2\frontend\models\items\PascalCase $model, mixed $params)
 * @method \yii2\frontend\models\forms\items\PascalCaseForm|null getForm(int $id)
 * @method \yii2\frontend\models\forms\items\PascalCaseForm createForm(array $params)
 * @method PascalCaseForm|null addForm(array $params)
 * @method PascalCaseForm|null updateForm(\yii2\frontend\models\forms\items\PascalCaseForm $form, mixed $params)
 * @method \yii2\frontend\models\items\PascalCase|null getActiveModel(int $id)
 * @method \yii2\frontend\models\forms\items\PascalCaseForm|null getActiveForm(int $id)
 * @method array getAllModels(string|array $criteria = [])
 * @method PascalCaseForm[] getAllForms(string|array $criteria = [])
 * @method PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method \yii2\frontend\models\forms\items\PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
 * @method int delete(PascalCase $model)
 *
 * @package app\frontend\components\services\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
 */
class PascalCaseService extends \yii2\common\components\services\items\PascalCaseService
{
    // {{Boilerplate}}
}