<?php declare(strict_types=1);

namespace common\components\base\controllers\items;

use yii\web\ErrorAction;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\enums\Action;
use common\components\base\models\items\sources\SourceModel;
use common\components\base\controllers\items\source\SourceWebController;

/**
 * < Common > Родительский класс для всех контроллеров веб-приложения
 * - BaseFrontendController
 * - BaseBackendController
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #web
 */
abstract class BaseWebController extends SourceWebController
{
    /**
     * Первый сегмент URL для обращения к контроллеру
     *
     * Обычно совпадает с именем контроллера в кебаб-кейсе
     *
     * @example Для контроллера `UserGroupController` будет `user-group`
     *
     * @var string
     */
    public const string ENDPOINT = '';



    /**
     * Массив с доступными действиями и методами для них
     *
     * Переопределяются в дочерних контроллерах согласно необходимым методам
     *
     * @var array
     */
    public const VERBS = [
        Action::INDEX => ['GET'],
        Action::VIEW => ['GET'],
        Action::CREATE => ['GET', 'POST'],
        Action::UPDATE => ['GET', 'POST'],
        Action::DELETE => ['DELETE'],
    ];



    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => '@common/views/system/error'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // @ - Authorized
                        // ? - Guest
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => static::VERBS,
            ],
        ];
    }


    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupLayoutNavBarConfig();
        $this->setupLayoutNavConfig();
    }


    /**
     * @param ?string $action
     *
     * @return string
     *
     * @tag #get #endpoint
     */
    public static function getEndpoint( ?string $action = null): string
    {
        $endpoint = static::ENDPOINT;

        if ($action === null ) $action = '';

        return "/$endpoint/$action";
    }


    /**
     * @return void
     */
    abstract protected function setupLayoutNavBarConfig(): void;

    /**
     * @return void
     */
    abstract protected function setupLayoutNavConfig(): void;
}