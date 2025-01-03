<?php declare(strict_types=1);

namespace backend\controllers;

use common\components\enums\Action;
use backend\components\controllers\parents\BackendController;

/**
 * < Backend > `SiteController`
 *
 * @package yii2\backend\controllers
 *
 * @tag #backend #controller #site
 */
class SiteController extends BackendController
{
    public const string ENDPOINT = 'site';

    public const array LABELS = [
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
