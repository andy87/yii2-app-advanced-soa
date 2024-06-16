<?php declare(strict_types=1);

namespace app\common\components\models;

use yii\base\Model;
use app\common\{ models\dto\EmailDto, components\interfaces\ModelEmailingInterface };

/**
 * < Common > `EmailingModel`
 *
 * @package app\frontend\components\model
 */
abstract class EmailingModel extends Model implements ModelEmailingInterface
{
    /** @var array  */
    protected array $messageConfig = [];



    /**
     * @param array $params
     *
     * @return array
     */
    public function getEmailComposeConfig(array $params = []): array
    {
        if ( count($params) ) $this->messageConfig['params'] = $params;

        return $this->messageConfig;
    }

    /**
     * @return EmailDto
     */
    abstract public function constructEmailDto(): EmailDto;
}