<?php

use frontend\resources\site\SiteContactResources;
use yii\bootstrap5\{ActiveForm, Html};
use yii\captcha\Captcha;
use yii2\frontend\controllers\SiteController;

/**
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var SiteContactResources $R
 */

$contactForm = $R->contactForm;

$this->title = SiteController::TITLES[SiteController::ACTION_CONTACT];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-contact" <?=$this->attrDataTemplate(__FILE__)?>>

    <h1><?= Html::encode($contactForm::HEADER) ?></h1>

    <p><?= $contactForm::HINT ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $contactForm->id]); ?>

                <?= $form->field($contactForm, $contactForm::ATTR_NAME)->textInput(['autofocus' => true]) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_EMAIL) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_SUBJECT) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_BODY)->textarea(['rows' => 6]) ?>

                <?php try
                    {
                        echo $form->field($contactForm, $contactForm::ATTR_VERIFY_CODE)
                            ->widget(Captcha::class, [
                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            ]);

                    }  catch (\Exception $e) {

                        echo $e->getMessage();
                    }
                ?>

                <div class="form-group">
                    <?= Html::submitButton($contactForm::BUTTON_SEND_TEXT, ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
