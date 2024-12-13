<?php

/**
 * This class only exists here for IDE (PHPStorm/Netbeans/...) autocompletion.
 * This file is never included anywhere.
 * Adjust this file to match classes configured in your application config, to enable IDE autocompletion for custom components.
 * Example: A property phpdoc can be added in `__Application` class as `@property \vendor\package\Rollbar|__Rollbar $rollbar` and adding a class in this file
 * ```php
 * // @property of \vendor\package\Rollbar goes here
< Common > __Rollbar {
 * }
 * ```
 */

use yii\web\User;
use yii2\common\models\Identity;
use yii\web\Application as AppWeb;
use yii\console\Application as AppConsole;

/**
 * < Common > Yii class is used for IDE autocompletion only.
 */
class Yii
{
    /**
     * @var AppWeb|AppConsole|__Application
     */
    public static $app;
}

/**
 * @property \yii $authManager
 * @property User|\__WebUser $identity
 *
 */
class __Application
{

}

/**
 * @property Identity $identity
 */
class __WebUser
{

}
