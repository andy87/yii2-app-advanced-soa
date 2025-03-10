<?php

namespace yii2\common\components\handlers;

use yii2\common\components\core\BaseHandler;
use yii2\common\components\resources\TemplateResources;

/**
 *
 */
class TemplateHandler extends BaseHandler
{
    /** @var array  */
    public array $resources;



    /**
     * @param string $action
     *
     * @return TemplateResources|string|null
     */
    public function getResource( string $action ): TemplateResources|string|null
    {
        $className = $this->resources[$action];

        return new $className();
    }
}