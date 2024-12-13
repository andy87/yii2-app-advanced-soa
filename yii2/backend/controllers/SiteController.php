<?php declare(strict_types=1);

namespace yii2\backend\controllers;

use yii2\backend\components\controllers\BaseBackendController;
use yii2\common\components\Action;

/**
 * < Backend > `SiteController`
 *
 * @package yii2\backend\controllers
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
