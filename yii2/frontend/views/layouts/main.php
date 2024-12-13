<?php

use yii\web\View;
use yii2\common\widgets\Alert;
use yii2\common\components\Layout;
use yii2\frontend\assets\AppAsset;
use yii\bootstrap5\{ Nav, Html, NavBar, Breadcrumbs };

/** @var View $this */
/** @var string $content */

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="<?=Layout::$class['html']?>" data-env="frontend" <?=$this->attrDataTemplate(__FILE__)?>>

    <head>

        <meta charset="<?= Yii::$app->charset ?>">

        <?= Layout::meta(Layout::META_VIEWPORT) ?>

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>

    </head>

    <body class="<?=Layout::$class['body']?>">

        <?php $this->beginBody() ?>

        <header>
            <?php try
                {
                    NavBar::begin(Layout::$navBarConfig);

                        echo Nav::widget(Layout::$navConfig);

                        echo Layout::getHtmlAuthBlock();

                    NavBar::end();

                } catch (Exception|Throwable $e) {

                    echo $e->getMessage();
                }
            ?>
        </header>

        <main role="main" class="<?=Layout::$class['main']?>">
            <div class="container">
                <?php try
                    {
                        Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? [] ]);

                        echo Alert::widget();

                    } catch (Exception|Throwable $e) {

                        echo $e->getMessage();
                    }
                    echo $content;
                ?>
            </div>
        </main>

        <footer class="<?=Layout::$class['footer']?>">
            <div class="container">
                <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
                <p class="float-end"><?= Layout::getHtmlCopyRight() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>

    </body>

</html>
<?php $this->endPage();