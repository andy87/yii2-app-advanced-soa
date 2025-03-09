<?php

namespace yii2\common\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii2\common\models\sources\Role;

class Auth
{
    public const ENDPOINT = 'auth';

    public const ACTION_SIGNUP = 'signup';
    public const ACTION_REQUEST_PASSWORD_RESET = 'request-password-reset';
    public const ACTION_RESET_PASSWORD = 'reset-password';
    public const ACTION_VERIFY_EMAIL = 'verify-email';
    public const ACTION_RESEND_VERIFICATION_EMAIL = 'resend-verification-email';
    public const ACTION_REQUEST_PASSWORD_RESET_TOKEN = 'request-password-reset-token';


    public const LABELS = [
        Action::LOGIN => 'Вход',
        Auth::ACTION_SIGNUP => 'Регистрация',
        Auth::ACTION_REQUEST_PASSWORD_RESET => 'Запрос сброса пароля',
        Auth::ACTION_RESET_PASSWORD => 'Сброс пароля',
        Auth::ACTION_VERIFY_EMAIL => 'Подтверждение email',
        Auth::ACTION_RESEND_VERIFICATION_EMAIL => 'Повторное подтверждение email',
        Auth::ACTION_REQUEST_PASSWORD_RESET_TOKEN => 'Запрос токена сброса пароля',
    ];

    public const BEHAVIORS = [
        'access' => [
            'class' => AccessControl::class,
            'only' => [ Action::LOGIN, Action::LOGOUT, Auth::ACTION_SIGNUP],
            'rules' => [
                [
                    'actions' => [
                        Action::LOGIN,
                        Auth::ACTION_SIGNUP
                    ],
                    'allow' => true,
                    'roles' => [Role::GUEST],
                ],
                [
                    'actions' => [Action::LOGOUT],
                    'allow' => true,
                    'roles' => [Role::USER],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
                Action::LOGOUT => ['post'],
            ],
        ],
    ];
}