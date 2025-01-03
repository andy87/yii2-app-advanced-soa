<?php declare(strict_types=1);

namespace common\components\base\resources\crud;

use yii\data\ActiveDataProvider;
use common\components\interfaces\models\SearchModelInterface;
use common\components\base\resources\items\BaseTemplateResource;

/**
 * < Common > Базовый родительский класс для ресурса индекса
 *
 * @package app\common\components\base\resources
 *
 * @tag: #abstract #common #resource #base #crud #index
 */
abstract class BaseGridViewResource extends BaseTemplateResource
{
    /** @var ActiveDataProvider */
    public ActiveDataProvider $activeDataProvider;

    /** @var SearchModelInterface */
    public SearchModelInterface $searchModel;
}