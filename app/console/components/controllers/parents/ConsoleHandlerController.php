<?php declare(strict_types=1);

namespace app\console\components\controllers\parents;

use app\console\components\handlers\parents\ConsoleHandler;
use app\console\models\forms\items\PascalCaseForm;
use app\console\models\items\PascalCase;
use Exception;
use yii\console\ExitCode;
use yii\base\InvalidConfigException;
use app\common\components\base\controllers\items\BaseConsoleHandlerController;

/**
 * < Console > Родительский класс для всех консольных контроллеров
 *
 * @property ConsoleHandler $handler
 *
 * @package app\backend\components\controllers\parent
 *
 * @tag: #abstract #console #parent #controller
 */
abstract class ConsoleHandlerController extends BaseConsoleHandlerController
{
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
        $model = $this->handler->service->producer->model->create($params);

        return $model;
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
            return $this->handler->service->updateModel( $model, $params );
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
    public function processViewModel( int $id ): ?PascalCase
    {
        return $this->findByID($id);
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
        $form = $this->handler->service->producer->form->create( $params );

        return $form;
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws \yii\db\Exception
     */
    public function processUpdateForm(int $id, array $params ): ?PascalCase
    {
        $form = $this->handler->service->repository->find($id);

        if ( $form )
        {
            $this->handler->service->updateForm( $form, $params );

            return $form;
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
        return $this->handler->service->getModel($id);
    }
}