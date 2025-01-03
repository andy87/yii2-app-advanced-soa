<?php

namespace common\components\base\producers;

use yii\base\Exception;
use yii\db\Exception as DbException;
use common\components\base\producers\items\source\SourceProducer;
use commonmodels\Identity;
use frontend\models\forms\SignupForm;

/**
 * < Common > Родительский класс для всех продюсеров
 *
 * @method Identity modelCreate(array $data = [])
 *
 * @package yii2\common\components\base\producers
 *
 * @tag: #abstract #common #producer
 */
class IdentityProducer extends SourceProducer
{
    /**
     * @param SignupForm $signupForm
     *
     * @return Identity
     *
     * @throws DbException|Exception
     */
    public function createBySignUpForm( SignupForm $signupForm ): Identity
    {
        $identity = $this->modelCreate();

        $identity->setAttribute($identity::ATTR_USERNAME, $signupForm->username);
        $identity->setAttribute($identity::ATTR_EMAIL, $signupForm->email);
        $identity->setPassword($signupForm->password);
        $identity->generateAuthKey();
        $identity->generateEmailVerificationToken();

        $identity->save();

        return $identity;
    }
}