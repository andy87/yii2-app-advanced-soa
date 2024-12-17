<?php declare(strict_types=1);

namespace yii2\common\components\services;

use yii2\common\components\base\models\items\sources\SourceModel;

/**
 * < Common > `FormService`
 *
 * @package yii2\common\components\services
 */
abstract class FormService extends ModelService
{
    /** @var string  */
    public const CLASS_FORM = SourceModel::class;



    /**
     * @return SourceModel|string
     *
     * @tag #core #service #get
     */
    public function getClassForm(): SourceModel|string
    {
        /** @var static|string $classForm */
        $classForm = static::CLASS_FORM;

        return $classForm;
    }

    /**
     * @param array $attributes
     *
     * @return SourceModel|string
     *
     * @tag #core #service #create
     */
    public function createForm(array $attributes = []): SourceModel|string
    {
        $classForm = $this->getClassModel();

        return new $classForm($attributes);
    }
}