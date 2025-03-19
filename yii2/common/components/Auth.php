<?php

namespace yii2\common\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii2\common\models\sources\Role;

class Auth
{
    public const ENDPOINT = 'auth';

    public const ACTION_LOGIN = 'login';
    public const ACTION_LOGOUT = 'logout';
    public const ACTION_SIGNUP = 'signup';
    public const ACTION_REQUEST_PASSWORD_RESET = 'request-password-reset';
    public const ACTION_RESET_PASSWORD = 'reset-password';
    public const ACTION_VERIFY_EMAIL = 'verify-email';
    public const ACTION_RESEND_VERIFICATION_EMAIL = 'resend-verification-email';
    public const ACTION_REQUEST_PASSWORD_RESET_TOKEN = 'request-password-reset-token';


    public const LABELS = [
        self::ACTION_LOGIN => 'Вход',
        self::ACTION_SIGNUP => 'Регистрация',
        self::ACTION_REQUEST_PASSWORD_RESET => 'Запрос сброса пароля',
        self::ACTION_RESET_PASSWORD => 'Сброс пароля',
        self::ACTION_VERIFY_EMAIL => 'Подтверждение email',
        self::ACTION_RESEND_VERIFICATION_EMAIL => 'Повторное подтверждение email',
        self::ACTION_REQUEST_PASSWORD_RESET_TOKEN => 'Запрос токена сброса пароля',
    ];

    public const BEHAVIORS = [
        'access' => [
            'class' => AccessControl::class,
            'only' => [ self::ACTION_LOGIN, self::ACTION_LOGOUT, self::ACTION_SIGNUP],
            'rules' => [
                [
                    'actions' => [
                        self::ACTION_LOGIN,
                        self::ACTION_SIGNUP
                    ],
                    'allow' => true,
                    'roles' => [Role::GUEST],
                ],
                [
                    'actions' => [Auth::ACTION_LOGOUT],
                    'allow' => true,
                    'roles' => [Role::USER],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
                Auth::ACTION_LOGOUT => ['post'],
            ],
        ],
    ];
}