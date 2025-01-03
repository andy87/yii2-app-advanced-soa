<?php

namespace common\repository\items;

use yii2\common\components\base\models\items\sources\SourceModel;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\models\sources\User;

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