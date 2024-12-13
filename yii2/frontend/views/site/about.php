<?php

use yii\web\View;
use yii\helpers\Html;
use yii2\frontend\controllers\SiteController;
use yii2\frontend\resources\site\SiteAboutResources;

/**
 * @var View $this
 * @var SiteAboutResources $R
 */

$this->title = SiteController::LABELS[SiteController::ACTION_ABOUT];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-about" <?=$this->attrDataTemplate(__FILE__)?>>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Это страница О нас. Вы можете изменить следующий файл, чтобы настроить его содержимое:</p>

    <code><?= __FILE__ ?></code>
</div>
