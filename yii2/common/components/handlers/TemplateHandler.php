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
     * @return TemplateResources|string
     */
    public function getResource( string $action ): TemplateResources|string
    {
        return $this->resources[$action] ?? null;
    }
}