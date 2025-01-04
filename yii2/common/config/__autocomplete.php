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
use common\models\Identity;
use yii\web\Application as AppWeb;
use common\managers\CommonHandlerManager;
use common\managers\CommonServiceManager;
use yii\console\Application as AppConsole;
use console\managers\ConsoleServiceManager;
use backend\managers\BackendServiceManager;
use backend\managers\BackendHandlerManager;
use console\managers\ConsoleHandlerManager;
use common\managers\CommonRepositoryManager;
use frontend\managers\FrontendHandlerManager;
use backend\managers\BackendRepositoryManager;
use console\managers\ConsoleRepositoryManager;
use frontend\managers\FrontendRepositoryManager;

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
 * @property User|__WebUser $identity
 * @property-read CommonServiceManager|ConsoleServiceManager|BackendServiceManager $serviceManager
 * @property-read CommonHandlerManager|ConsoleHandlerManager|FrontendHandlerManager|BackendHandlerManager $handlerManager
 * @property-read CommonRepositoryManager|ConsoleRepositoryManager|FrontendRepositoryManager|BackendRepositoryManager $repositoryManager
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
