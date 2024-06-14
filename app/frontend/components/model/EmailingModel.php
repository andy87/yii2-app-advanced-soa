<?php declare(strict_types=1);

namespace app\frontend\components\model;

use yii\base\Model;
use app\common\models\dto\EmailDto;
use app\frontend\components\interfaces\ModelEmailingInterface;

/**
 * Class `EmailingModel`
 *
 * @package app\frontend\components\model
 */
abstract class EmailingModel extends Model implements ModelEmailingInterface
{
    /** @var string $composeHtml */
    public string $composeHtml;


    /** @var string $composeView */
    public string $composeView;



    /**
     * @param array $params
     *
     * @return array
     */
    public function getEmailComposeConfig(array $params): array
    {
        return [
            'html' => $this->composeHtml,
            'view' => $this->composeView,
            'params' => $params,
        ];
    }

    /**
     * @return EmailDto
     */
    abstract public function constructEmailDto(): EmailDto;
}