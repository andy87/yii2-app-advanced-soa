<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\backend\assets\AppAsset;
use app\common\components\Layout;
use yii\helpers\Html;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Layout::meta(Layout::META_VIEWPORT) ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?=Layout::$body['class']?>">
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
