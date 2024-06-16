<?php declare(strict_types=1);

namespace app\common\components\traits;

use Yii;
use yii\web\Session;

/**
 * < Common > `Flash`
 *
 * @package app\common\components\trair
 */
trait SessionFlash
{
    /**
     * @param bool $criteria
     * @param string $success
     * @param string $error
     *
     * @return void
     */
    public function setSessionFlashMessage( bool $criteria, string $success, string $error ): void
    {
        if ( $criteria ) {
            $this->setSessionFlashSuccess($success);
        } else {
            $this->setSessionFlashError($error);
        }
    }

    /**
     * @param $value
     *
     * @return void
     */
    public function setSessionFlashSuccess($value): void
    {
        $this->setSessionFlash('success', $value);
    }

    /**
     * @param $value
     *
     * @return void
     */
    public function setSessionFlashError($value): void
    {
        $this->setSessionFlash('error', $value);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function setSessionFlash($key, $value): void
    {
        $this
            ->getSession()
            ->setFlash($key, $value);
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return Yii::$app->session;
    }
}