<?php declare(strict_types=1);

namespace common\components\system;

use Yii;
use Exception;
use JsonException;
use yii\base\BaseObject;

/**
 * < Common > Class Notify
 *
 * @package yii2\common\components
 *
 * @tag: #common #component #notify
 */
class Notify extends BaseObject
{
    public const string INFO = 'info';
    public const string ERROR = 'error';
    public const string WARNING = 'warning';
    public const string SUCCESS = 'success';


    /**
     * @param string $message
     * @param string $type
     *
     * @return bool
     *
     * @throws JsonException|Exception
     */
    public static function send( string $message, string $type = self::INFO ): bool
    {
        try
        {
            $session = Yii::$app->session;

            $session->setFlash( $type, $message );

            return true;

        } catch (Exception $exception) {

            Logger::catchHandler($exception, __METHOD__, 'Catch! Notify::send()',[
                'message' => $message,
                'type' => $type,
            ]);
        }

        return false;
    }
}