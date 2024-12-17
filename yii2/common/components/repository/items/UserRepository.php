<?php

namespace yii2\common\components\repository\items;

use yii2\common\models\sources\User;
use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\repository\items\source\SourceRepository;

/**
 * < Common > `UserRepository`
 *
 * @package yii2\common\repositories\items
 *
 * @tag #repositories #user
 */
class UserRepository extends SourceRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    public SourceModel|string $modelClass = User::class;
}