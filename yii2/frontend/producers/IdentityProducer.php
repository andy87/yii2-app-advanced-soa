<?php

namespace yii2\frontend\producers;

use yii2\common\models\Identity;
use yii\db\ActiveRecordInterface;
use yii2\common\components\core\BaseProduces;

/**
 *
 */
class IdentityProducer extends BaseProduces
{
    public ActiveRecordInterface|string $modelClass = Identity::class;
}