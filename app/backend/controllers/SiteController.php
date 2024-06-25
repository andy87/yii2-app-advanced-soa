<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\backend\components\controllers\BaseBackendController;
use app\common\components\Action;

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
    public const LABELS = [
        Action::INDEX => 'Главная',
    ];

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
