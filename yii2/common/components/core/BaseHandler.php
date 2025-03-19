<?php

namespace yii2\common\components\core;

use Exception;
use yii\base\BaseObject;
use yii2\common\components\resources\TemplateResources;
use yii2\common\components\traits\Logger;

/**
 * < Common > `BaseHandler`
 *
 * @package yii2\common\components\core
 */
class BaseHandler extends BaseObject
{
    use Logger;


    /** @var array */
    public array $resources = [];



    /**
     * @param string $name
     *
     * @return ?TemplateResources
     *
     * @throws Exception
     */
    public function getResources( string $name ): ?TemplateResources
    {
        $resources = $this->resources[$name] ?? null;

        if ( $resources )
        {
            return new $resources();
        }

        $message = "Ожидалось что ресурс для action: `$name` будет найден в массиве \$this->resources";

        $this->addLogError($message, __METHOD__, [
            'name' => $name,
            'resources' => $this->resources,
        ]);

        return null;
    }
}