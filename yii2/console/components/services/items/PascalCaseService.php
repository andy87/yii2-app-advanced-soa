<?php declare(strict_types=1);

namespace yii2\console\components\services\items;

use yii2\console\models\items\PascalCase;
use yii2\console\models\forms\items\PascalCaseForm;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\console\components\producers\items\PascalCaseProducer;
use yii2\console\components\repository\items\PascalCaseRepository;
use yii2\console\components\dataProviders\items\PascalCaseDataProvider;
use yii2\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Console > Сервис для работы с сущностью `PascalCase`
 *
 * @property CatcherInterface $logger
 * @property PascalCaseProducer $producer
 * @property PascalCaseRepository $repository
 * @property \yii2\console\components\dataProviders\items\PascalCaseDataProvider $dataProvider
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
 * @method \yii2\console\models\items\PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
 * @method int delete(\yii2\console\models\items\PascalCase $model)
 *
 * @package app\console\components\services\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseService extends \yii2\common\components\services\items\PascalCaseService
{
    // {{Boilerplate}}
}