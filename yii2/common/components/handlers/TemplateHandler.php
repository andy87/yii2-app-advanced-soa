<?php

namespace yii2\common\components\handlers;

use yii2\common\components\core\BaseHandler;
use yii2\common\components\interfaces\handlers\TemplateHandlerInterface;
use yii2\common\components\viewModels\TemplateViewModel;

/**
 *
 */
class TemplateHandler extends BaseHandler implements TemplateHandlerInterface
{
    /** @var array  */
    public array $resources;



    /**
     * @param string $action
     *
     * @return TemplateViewModel|string|null
     */
    public function getResource( string $action ): TemplateViewModel|null
    {
        $className = $this->resources[$action];

        return new $className();
    }
}