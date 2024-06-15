<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\backend\components\controllers\BaseBackendController;

/**
 * < Backend > `SiteController`
 *
 * @package app\backend\controllers
 *
 * @tag #backend #controller #site
 */
class SiteController extends BaseBackendController
{
    public const ENDPOINT = 'site';

    /**
     * Displays homepage.
     *
     * @return string
     *
     * @tag #backend #site #index
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
