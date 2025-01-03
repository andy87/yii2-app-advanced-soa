<?php

namespace common\components;

/**
 *
 */
class AccessControl extends \yii\filters\AccessControl
{
    public const string USER = '@';
    public const string GUEST = '?';
}