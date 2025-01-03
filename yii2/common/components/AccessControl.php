<?php

namespace common\components;

/**
 *
 */
class AccessControl extends \yii\filters\AccessControl
{
    public const string ROLE_USER = '@';
    public const string ROLE_GUEST = '?';
}