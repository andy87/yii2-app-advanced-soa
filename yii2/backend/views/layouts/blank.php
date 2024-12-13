<?php

use yii\web\View;
use yii\helpers\Html;
use yii2\backend\assets\AppAsset;
use yii2\common\components\Layout;

/** @var View $this */
/** @var string $content */

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="<?=Layout::$class['html']?>" <?=$this->attrDataTemplate(__FILE__)?>>

    <head>
        <meta charset="<?= Yii::$app->charset ?>">

        <?= Layout::meta(Layout::META_VIEWPORT) ?>

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>

    </head>

    <body class="<?=Layout::$class['body']?>">

        <?php $this->beginBody() ?>

        <main role="main">

            <div class="container">

                <?= $content ?>

            </div>

        </main>

        <?php $this->endBody() ?>

    </body>

</html>
<?php $this->endPage();
