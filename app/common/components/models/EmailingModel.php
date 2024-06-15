<?php declare(strict_types=1);

namespace app\common\components\models;

use app\common\components\interfaces\ModelEmailingInterface;
use app\common\models\dto\EmailDto;
use yii\base\Model;

/**
 * < Common > `EmailingModel`
 *
 * @package app\frontend\components\model
 */
abstract class EmailingModel extends Model implements ModelEmailingInterface
{
    /** @var ?string $composeHtml */
    public ?string $composeHtml = null;


    /** @var ?string $composeView */
    public ?string $composeView = null;


    /** @var ?string $composeText */
    public ?string $composeText = null;



    /**
     * @param array $params
     *
     * @return array
     */
    public function getEmailComposeConfig(array $params): array
    {
        $composeConfig = [];

        if ($this->composeHtml) $composeConfig['html'] = $this->composeHtml;
        if ($this->composeView) $composeConfig['view'] = $this->composeView;
        if ($this->composeText) $composeConfig['text'] = $this->composeText;

        $composeConfig['params'] = $params;

        return $composeConfig;
    }

    /**
     * @return EmailDto
     */
    abstract public function constructEmailDto(): EmailDto;
}