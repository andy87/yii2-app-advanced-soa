<?php declare(strict_types=1);

namespace app\console\components\controllers\parents;

use app\console\models\forms\items\PascalCaseForm;
use Exception;
use Throwable;
use yii\console\ExitCode;
use app\common\components\models\dto\ModelInfo;
use app\common\components\traits\handlers\ConsoleHandler;
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
     * Список моделей
     *
     * @cli php yii items/pascal-case/list {page:int} {perPage:int}
     * @cli php yii items/pascal-case/list 1 10
     *
     * @param int $page
     * @param int $limit
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionList(int $page = 1, int $limit = 10): int
    {
        $this->printConsoleFuncStart(__METHOD__);

        $models = $this->handler->processList($page, $limit);

        $this->printConsole('Result');

        if (count($models) > 0)
        {
            $this->printConsoleSuccess('Models found: ' . count($models));

            $list = [];

            foreach ($models as $model)
            {
                $list[$model->id] = $model->attributes;
            }
            print_r($list);

        } else {

            $this->printConsoleError('Models NOT found');
        }

        $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;
    }

    /**
     * Создание модели
     *
     * @cli php yii items/pascal-case/model-add {string:json}
     * @cli php yii items/pascal-case/model-add "{\"column\": \"string\", \"count\": \"1\", \"content\": \"xxx\"}"
     *
     * @param string $json JSON-строка с параметрами
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionModelAdd( string $json ): int
    {
        $this->printConsoleFuncStart(__METHOD__);

        $params = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $model = $this->handler->processModelAdd( $params );

        $this->printConsole('Result');

        if ( $model && isset( $model->id ) && !$model->isNewRecord )
        {
            $this->printConsoleSuccess("Model added: $model->id" . PHP_EOL );

        } else {

            $this->printConsoleError('Model NOT added');
        }

        print_r(new ModelInfo($model));

        $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;
    }

    /**
     * Просмотр модели
     *
     * @cli php yii items/pascal-case/model-view 1
     *
     * @param int $id ID модели
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionModelView( int $id ): int
    {
        $this->printConsoleFuncStart(__METHOD__);

        $model = $this->handler->processViewModel( $id );

        $this->printConsole('Result');

        if ($model)
        {
            $this->printConsoleSuccess("Model found: $model->id" . PHP_EOL );

            print_r(new ModelInfo($model));

        } else {

            $this->printConsoleError('Model NOT found');
        }

        $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;
    }

    /**
     * Обновление модели
     *
     * @cli php yii items/pascal-case/model-update 1 '{"name": "value"}'
     *
     * @param int $id ID модели
     * @param string $json JSON-строка с параметрами
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionModelUpdate( int $id, string $json ): int
    {
        $this->printConsoleFuncStart(__METHOD__);

        $params = json_decode( $json, true, 512, JSON_THROW_ON_ERROR );

        $model = $this->handler->processModelUpdate( $id, $params );

        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            print_r(new ModelInfo($model));

            $this->printConsole('Result');

            if ( $model->save() )
            {
                $this->printConsoleSuccess("Model updated: $model->id");

            } else {

                $this->printConsoleError('Model NOT updated' . PHP_EOL);

                print_r($model->errors);
            }
        }

        $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;

    }

    /**
     * Удаление объекта по ID
     *
     * @cli php yii items/pascal-case/delete 1
     *
     * @param int $id ID модели
     *
     * @return int
     *
     * @throws Exception|Throwable
     */
    public function actionDelete( int $id ): int
    {
        $this->printConsoleFuncStart(__METHOD__);

        $model = $this->handler->processDelete( $id, PascalCaseForm::class );

        ( $model === null )
            ? $this->printConsoleError("Model id:`$id` not found")
            : $this->printConsoleSuccess("Model id:`$id` deleted");

        $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;
    }
}