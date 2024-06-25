<?php

use yii\web\View;
use yii\helpers\Html;
use app\frontend\controllers\SiteController;
use app\frontend\resources\site\SiteAboutResources;

/**
 * @var View $this
 * @var SiteAboutResources $R
 */

$this->title = SiteController::LABELS[SiteController::ACTION_ABOUT];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-about" <?=$this->attrDataTemplate(__FILE__)?>>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
