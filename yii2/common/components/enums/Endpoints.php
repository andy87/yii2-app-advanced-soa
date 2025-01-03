<?php

namespace common\components\enums;

/**
 * < Common > `Action`
 *
 * @package yii2\common\components
 */
enum Endpoints: string
{
    /** @var string $Index */
    case Error = 'error';

    /** @var string $Login */
    case Login = 'login';

    /** @var string $Logout */
    case Logout = 'logout';

    /** @var string $Search */
    case Search = 'search';

    /** @var string $List */
    case List = 'list';

    /** @var string $Export */
    case Export = 'export';

    /** @var string $Import */
    case Import = 'import';

    /** @var string $Edit */
    case Edit = 'edit';

    /** @var string $Remove */
    case Remove = 'remove';


    public const string ERROR = self::Error->value;

    public const string LOGIN = self::Login->value;
    public const string LOGOUT = self::Logout->value;

    public const string SEARCH = self::Search->value;

    public const string LIST = self::List->value;

    public const string EXPORT = self::Export->value;

    public const string IMPORT = self::Import->value;

    public const string EDIT = self::Edit->value;

    public const string REMOVE = self::Remove->value;
}