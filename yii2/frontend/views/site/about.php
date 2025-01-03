<?php

use frontend\resources\site\SiteAboutResources;
use yii\helpers\Html;
use yii\web\View;
use yii2\frontend\controllers\SiteController;

/**
 * @var View $this
 * @var \frontend\resources\site\SiteAboutResources $R
 */

$this->title = SiteController::TITLES[SiteController::ACTION_ABOUT];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-about" <?=$this->attrDataTemplate(__FILE__)?>>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Это страница О нас. Вы можете изменить следующий файл, чтобы настроить его содержимое:</p>

    <code><?= __FILE__ ?></code>
</div>
