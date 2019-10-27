<?php
namespace backend\controllers;

/**
 * tools
 */
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * models
 */
use app\models\Apple;
use app\models\Apples;
use app\models\Colors;
use app\models\Status;

/**
 * Class AppleController
 * @package backend\controllers
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['task', 'generation'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionGeneration()
    {
        $applesTree = new Apples();
        $applesTree->generation(rand(15, 25));

        return $this->render(
            'task/generation',
            [
                'apples' => Apples::find()->orderBy('id')->asArray()->all(),
                'colors' => Colors::find()->orderBy('id')->asArray()->all(),
                'status' => Status::find()->orderBy('id')->asArray()->all(),
            ]
        );
    }

    /**
     * @return string
     */
    public function actionTask()
    {
        $abstractApple = new Apple('red');
        $abstractApple->saveAppleToTree();
        /*var_dump('<pre>', $abstractApple->color);*/

        $applesTree = new Apples();
        $deleted = $applesTree->clearTree('black'); // Пока висит на дереве - испортиться не может. Плохие удаляются при осмотре дерева.

        return $this->render(
            'task',
            [
                'deleted' => $deleted,
                'apples' => Apples::find()->orderBy('id')->asArray()->all(),
                'colors' => Colors::find()->orderBy('id')->asArray()->all(),
                'status' => Status::find()->orderBy('id')->asArray()->all(),
            ]
        );
    }
}
