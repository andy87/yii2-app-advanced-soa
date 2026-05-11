<?php declare(strict_types=1);

namespace yii2\frontend\domains\auth;

use RuntimeException;
use Yii;
use yii\validators\EmailValidator;
use andy87\yii2dnk\domain\BaseService;
use yii2\common\components\Result;
use yii2\common\models\Identity;
use yii2\common\models\dto\EmailMessageDto;
use yii2\common\models\forms\LoginForm;
use yii2\common\services\EmailService;
use yii2\frontend\domains\auth\payloads\AuthLoginPayload;
use yii2\frontend\domains\auth\payloads\AuthRequestPasswordResetPayload;
use yii2\frontend\domains\auth\payloads\AuthResendVerificationEmailPayload;
use yii2\frontend\domains\auth\payloads\AuthResetPasswordPayload;
use yii2\frontend\domains\auth\payloads\AuthVerifyEmailPayload;
use yii2\frontend\models\forms\PasswordResetRequestForm;
use yii2\frontend\models\forms\ResendVerificationEmailForm;
use yii2\frontend\models\forms\ResetPasswordForm;
use yii2\frontend\models\forms\SignupForm;

/**
 * DNK service домена авторизации.
 *
 * Содержит бизнес-операции login/reset-password без чтения request и без render.
 */
class AuthService extends BaseService
{
    protected const DOMAIN = AuthDomain::class;

    private ?EmailService $emailService = null;

    /**
     * Обрабатывает форму входа пользователя.
     *
     * @param LoginForm $loginForm Форма входа, отображаемая view-model.
     * @param AuthLoginPayload $payload Входные данные DNK payload.
     * @return bool True, если пользователь авторизован.
     * @throws \yii\base\InvalidConfigException Если repository или identity настроены неверно.
     */
    public function login(LoginForm $loginForm, AuthLoginPayload $payload): bool
    {
        if (!$payload->isPost) {
            return false;
        }

        $loginForm->load($payload->formData);

        $loginForm->clearErrors();

        if (!$this->validateLoginInput($loginForm)) {
            $loginForm->result = Result::ERROR;
            $loginForm->password = '';

            return false;
        }

        $identity = $this->authRepository()->findActiveByUsername($loginForm->username);

        if ($identity === null || !$identity->validatePassword((string)$loginForm->password)) {
            $loginForm->addError(LoginForm::ATTR_PASSWORD, LoginForm::RULE_MESSAGE_WRONG_USER_NAME_OR_PASSWORD);
            $loginForm->result = Result::ERROR;
            $loginForm->password = '';

            return false;
        }

        $duration = $loginForm->rememberMe
            ? 3600 * 24 * (int)Yii::$app->params[LoginForm::PARAM_REMEMBER_ME]
            : 0;

        if (!Yii::$app->user->login($identity, $duration)) {
            $loginForm->result = Result::ERROR;
            $loginForm->password = '';

            return false;
        }

        $loginForm->result = Result::OK;

        return true;
    }

    /**
     * Обрабатывает запрос письма для сброса пароля.
     *
     * @param PasswordResetRequestForm $form Форма запроса сброса пароля.
     * @param AuthRequestPasswordResetPayload $payload Входные данные DNK payload.
     * @return bool True, если письмо поставлено на отправку.
     * @throws \yii\base\Exception Если Yii security не смог сгенерировать token.
     */
    public function requestPasswordReset(PasswordResetRequestForm $form, AuthRequestPasswordResetPayload $payload): bool
    {
        if (!$payload->isPost) {
            return false;
        }

        $form->load($payload->formData);
        $form->email = is_string($form->email) ? trim($form->email) : $form->email;
        $form->clearErrors();

        if (!$this->validateEmailInput($form, PasswordResetRequestForm::ATTR_EMAIL)) {
            $form->result = Result::ERROR;

            return false;
        }

        $identity = $this->authRepository()->findActiveByEmail($form->email);

        if ($identity === null) {
            $form->addError(PasswordResetRequestForm::ATTR_EMAIL, 'Нет пользователя с таким email.');
            $form->result = Result::ERROR;

            return false;
        }

        if (!Identity::isPasswordResetTokenValid((string)$identity->password_reset_token)) {
            $identity->generatePasswordResetToken();
        }

        if (!$identity->save(false)) {
            $form->result = Result::ERROR;

            return false;
        }

        $form->result = $this->sendPasswordResetEmail($identity) ? Result::OK : Result::ERROR;

        return $form->result === Result::OK;
    }

    /**
     * Обрабатывает повторную отправку письма подтверждения email.
     *
     * @param ResendVerificationEmailForm $form Форма повторной отправки подтверждения.
     * @param AuthResendVerificationEmailPayload $payload Входные данные DNK payload.
     * @return bool True, если письмо поставлено на отправку.
     */
    public function resendVerificationEmail(ResendVerificationEmailForm $form, AuthResendVerificationEmailPayload $payload): bool
    {
        if (!$payload->isPost) {
            return false;
        }

        $form->load($payload->formData);
        $form->email = is_string($form->email) ? trim($form->email) : $form->email;
        $form->clearErrors();

        if (!$this->validateEmailInput($form, ResendVerificationEmailForm::ATTR_EMAIL)) {
            $form->result = Result::ERROR;

            return false;
        }

        $identity = $this->authRepository()->findInactiveByEmail($form->email);

        if ($identity === null) {
            $form->addError(ResendVerificationEmailForm::ATTR_EMAIL, ResendVerificationEmailForm::RULE_EXIST_MESSAGE);
            $form->result = Result::ERROR;

            return false;
        }

        $form->result = $this->sendVerificationEmail($identity) ? Result::OK : Result::ERROR;

        return $form->result === Result::OK;
    }

    /**
     * Обрабатывает форму установки нового пароля.
     *
     * @param ResetPasswordForm $resetPasswordForm Форма нового пароля.
     * @param AuthResetPasswordPayload $payload Входные данные DNK payload.
     * @return bool True, если пароль сохранён.
     * @throws \yii\base\Exception Если Yii security не смог сгенерировать hash/auth key.
     */
    public function resetPassword(ResetPasswordForm $resetPasswordForm, AuthResetPasswordPayload $payload): bool
    {
        if (!$payload->isPost) {
            return false;
        }

        $resetPasswordForm->load($payload->formData);

        if (!$resetPasswordForm->validate()) {
            $resetPasswordForm->result = Result::ERROR;

            return false;
        }

        $identity = $this->authRepository()->findByPasswordResetToken($payload->token);

        if ($identity === null || !Identity::isPasswordResetTokenValid((string)$identity->password_reset_token)) {
            $resetPasswordForm->addError(ResetPasswordForm::ATTR_PASSWORD, ResetPasswordForm::EXCEPTION_TOKEN_INVALID);
            $resetPasswordForm->result = Result::ERROR;

            return false;
        }

        $identity->setPassword((string)$resetPasswordForm->password);
        $identity->removePasswordResetToken();
        $identity->generateAuthKey();

        $resetPasswordForm->result = $identity->save(false) ? Result::OK : Result::ERROR;

        return $resetPasswordForm->result === Result::OK;
    }

    /**
     * Подтверждает email по verification token.
     *
     * @param AuthVerifyEmailPayload $payload Входной payload с token.
     * @return bool True, если email подтверждён и пользователь авторизован.
     * @throws \yii\base\InvalidConfigException Если repository настроен неверно.
     */
    public function verifyEmail(AuthVerifyEmailPayload $payload): bool
    {
        $identity = $this->authRepository()->findInactiveByVerificationToken($payload->token);

        if ($identity === null) {
            return false;
        }

        $identity->status = Identity::STATUS_ACTIVE;

        return $identity->save(false) && Yii::$app->user->login($identity);
    }

    /**
     * Валидирует вход login без legacy LoginForm::getIdentity().
     *
     * @param LoginForm $loginForm Форма входа.
     * @return bool True, если обязательные поля заполнены.
     */
    private function validateLoginInput(LoginForm $loginForm): bool
    {
        if ($loginForm->username === null || trim($loginForm->username) === '') {
            $loginForm->addError(LoginForm::ATTR_USERNAME, $this->requiredMessage($loginForm, LoginForm::ATTR_USERNAME));
        }

        if ($loginForm->password === null || $loginForm->password === '') {
            $loginForm->addError(LoginForm::ATTR_PASSWORD, $this->requiredMessage($loginForm, LoginForm::ATTR_PASSWORD));
        }

        return !$loginForm->hasErrors();
    }

    /**
     * Валидирует email без ActiveRecord exist validator.
     *
     * @param object $form Форма с email и addError().
     * @param string $attribute Имя email-атрибута.
     * @return bool True, если email заполнен и имеет корректный формат.
     */
    private function validateEmailInput(object $form, string $attribute): bool
    {
        $email = $form->{$attribute} ?? null;

        if (!is_string($email) || trim($email) === '') {
            $form->addError($attribute, $this->requiredMessage($form, $attribute));

            return false;
        }

        $validator = new EmailValidator();

        if (!$validator->validate($email)) {
            $form->addError($attribute, 'Некорректный адрес электронной почты');

            return false;
        }

        return true;
    }

    /**
     * Формирует required-сообщение с подставленным названием атрибута.
     *
     * @param object $form Форма, к которой относится ошибка.
     * @param string $attribute Имя атрибута формы.
     * @return string Текст validation error.
     */
    private function requiredMessage(object $form, string $attribute): string
    {
        $label = method_exists($form, 'getAttributeLabel')
            ? $form->getAttributeLabel($attribute)
            : $attribute;

        return str_replace('{attribute}', (string)$label, LoginForm::RULE_REQUIRED_MESSAGE);
    }

    /**
     * Отправляет письмо сброса пароля.
     *
     * @param Identity $identity Пользователь, запросивший сброс пароля.
     * @return bool True, если письмо отправлено.
     */
    private function sendPasswordResetEmail(Identity $identity): bool
    {
        $emailMessageDto = new EmailMessageDto();
        $emailMessageDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailMessageDto->fromName = Yii::$app->name . ' robot';
        $emailMessageDto->subject = 'Password reset for ' . Yii::$app->name;
        $emailMessageDto->to = $identity->email;
        $emailMessageDto->view = [
            'html' => 'passwordResetToken-html',
            'text' => 'passwordResetToken-text',
        ];
        $emailMessageDto->params = [
            'user' => $identity,
        ];

        return $this->getEmailService()->send($emailMessageDto);
    }

    /**
     * Отправляет письмо подтверждения email.
     *
     * @param Identity $identity Неактивный пользователь.
     * @return bool True, если письмо отправлено.
     */
    private function sendVerificationEmail(Identity $identity): bool
    {
        $emailMessageDto = new EmailMessageDto();
        $emailMessageDto->to = $identity->email;
        $emailMessageDto->subject = 'Account registration at ' . Yii::$app->name;
        $emailMessageDto->fromEmail = Yii::$app->params['supportEmail'];
        $emailMessageDto->fromName = Yii::$app->name . ' robot';
        $emailMessageDto->view = SignupForm::COMPOSE_MESSAGE_VIEW;
        $emailMessageDto->params = [
            'user' => $identity,
        ];

        return $this->getEmailService()->send($emailMessageDto);
    }

    /**
     * Возвращает сервис отправки email.
     *
     * @return EmailService Сервис отправки почты.
     */
    private function getEmailService(): EmailService
    {
        if ($this->emailService === null) {
            $this->emailService = Yii::createObject(EmailService::getConfig());
        }

        return $this->emailService;
    }

    /**
     * Возвращает repository домена авторизации с проверкой типа.
     *
     * @return AuthRepository Repository чтения Identity.
     */
    private function authRepository(): AuthRepository
    {
        $repository = $this->getRepository();

        if (!$repository instanceof AuthRepository) {
            throw new RuntimeException(sprintf(
                'Auth repository must be instance of "%s", "%s" given.',
                AuthRepository::class,
                $repository::class
            ));
        }

        return $repository;
    }
}
