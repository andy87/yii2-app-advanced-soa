<?php

use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\bootstrap5\ActiveForm;
use app\frontend\resources\site\SiteContactResources;

/**
 * @var yii\web\View $this
 * @var yii\bootstrap5\ActiveForm $form
 * @var SiteContactResources $R
 */

$contactForm = $R->contactForm;

$this->title = $contactForm::TITLE;
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="site-contact">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Если у вас есть деловые запросы или другие вопросы, пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => $contactForm->id]); ?>

                <?= $form->field($contactForm, $contactForm::ATTR_NAME)->textInput(['autofocus' => true]) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_EMAIL) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_SUBJECT) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_BODY)->textarea(['rows' => 6]) ?>

                <?= $form->field($contactForm, $contactForm::ATTR_VERIFY_CODE)->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
