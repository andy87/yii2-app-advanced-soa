<?php

namespace common\repository\items;

use common\components\base\models\items\sources\SourceModel;
use common\components\base\repository\items\source\SourceRepository;
use commonmodels\sources\User;

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