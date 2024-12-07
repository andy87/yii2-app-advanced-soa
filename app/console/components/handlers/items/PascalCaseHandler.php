<?php declare(strict_types=1);

namespace app\console\components\handlers\items;

use Exception;
use yii\base\InvalidConfigException;
use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\frontend\models\search\items\PascalCaseSearch;
use app\console\components\services\items\PascalCaseService;
use app\frontend\components\producers\items\PascalCaseProducer;
use app\frontend\components\repository\items\PascalCaseRepository;
use app\common\components\base\services\items\settings\ServiceSettings;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\console\components\handlers\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \app\common\components\handlers\items\PascalCaseHandler
{
    /**
     * @return ServiceSettings
     */
    public function getServiceSettings(): ServiceSettings
    {
        return new ServiceSettings(
            PascalCase::class,
            PascalCaseForm::class,
            PascalCaseSearch::class,
            PascalCaseDataProvider::class,
            PascalCaseService::class,
            PascalCaseProducer::class,
            PascalCaseRepository::class
        );
    }

    /**
     * @param int $id
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function processView( int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws \yii\db\Exception
     */
    public function processCreateModel( array $params ): ?PascalCase
    {
        /** @var ?PascalCase $model */
        $model = $this->service->producer->model->create($params);

        return $model;
    }

    /**
     * @param array $params
     *
     * @return ?PascalCaseForm
     *
     * @throws \yii\db\Exception
     */
    public function processCreateForm( array $params ): ?PascalCaseForm
    {
        /** @var ?PascalCaseForm $form */
        $form = $this->service->producer->form->create( $params );

        return $form;
    }

    /**
     *
     * @param int $id
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function processUpdateModel( int $id, array $params ): ?PascalCase
    {
        if ( $model = $this->findByID($id) )
        {
            return $this->service->updateModel( $model, $params );
        }

        return null;
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function processUpdateForm(int $id, array $params ): ?PascalCase
    {
        $form = $this->findByID($id);

        if ( $form )
        {
            return $this->service->updateModel( $form, $params );
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function processDelete( int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @param int $id
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException|Exception
     */
    private function findByID( int $id ): ?PascalCase
    {
        return $this->service->getItemById($id);
    }
}