<?php declare(strict_types=1);

namespace frontend\services\items;

use frontend\dataProviders\items\PascalCaseDataProvider;
use frontend\producers\items\PascalCaseProducer;
use frontend\repository\items\PascalCaseRepository;
use yii2\common\components\base\services\items\settings\ServiceSettings;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\frontend\models\forms\items\PascalCaseForm;
use yii2\frontend\models\items\PascalCase;

/**
 * < Frontend > Сервис для работы с сущностью `PascalCase`
 *
 * @property CatcherInterface $logger
 * @property PascalCaseProducer $producer
 * @property \frontend\repository\items\PascalCaseRepository $repository
 * @property \frontend\dataProviders\items\PascalCaseDataProvider $dataProvider
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
 * @method PascalCase[] getAllActiveModels(string|array $criteria = [])
 * @method PascalCaseForm[] getAllActiveForms(string|array $criteria = [])
 * @method int delete(PascalCase $model)
 *
 * @package app\frontend\components\services\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
 */
class PascalCaseService extends \common\services\items\PascalCaseService
{
    // {{Boilerplate}}
}