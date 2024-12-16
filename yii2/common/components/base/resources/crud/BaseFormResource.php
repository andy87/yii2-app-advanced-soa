<?php declare(strict_types=1);

namespace yii2\common\components\base\resources\crud;

use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\resources\items\BaseTemplateResource;

/**
 * < Common > Базовый класс для ресурса с формой в окружениях: `frontend`, `backend`
 *
 * @package app\common\components\base\resources
 *
 * @tag:0form
 */
abstract class BaseFormResource extends BaseTemplateResource
{
    /** @var ?SourceModel */
    public ?SourceModel $form = null;
}