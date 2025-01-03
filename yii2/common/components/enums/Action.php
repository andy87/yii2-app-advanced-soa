<?php declare(strict_types=1);

namespace common\components\enums;

/**
 * < Common > Class Action
 *
 * @package yii2\common\components
 *
 * @tag: #abstract #enum #action
 */
enum Action: string
{
    /** @var string $Index */
    case Index = 'index';

    /** @var string $View */
    case View = 'view';

    /** @var string $Create */
    case Create = 'create';

    /** @var string $Update */
    case Update = 'update';

    /** @var string $Delete */
    case Delete = 'delete';



    /** @var string $INDEX */
    public const string INDEX = self::Index->value;

    /** @var string $VIEW */
    public const string VIEW = self::View->value;

    /** @var string $CREATE */
    public const string CREATE = self::Create->value;

    /** @var string $UPDATE */
    public const string UPDATE = self::Update->value;

    /** @var string $DELETE */
    public const string DELETE = self::Delete->value;



    /**
     * Список действий к которым устанавливается доступ по методам
     * для проверки в тестах
     *
     * @var array
     */
    public const array VERB = [
        self::INDEX,
        self::VIEW,
        self::CREATE,
        self::UPDATE,
        self::DELETE,
    ];
}