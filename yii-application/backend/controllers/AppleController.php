<?php

namespace backend\controllers;

/**
 * use Yii tools
 */
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\base\ErrorException;

/**
 * use models
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
        try {

            $applesTree = new Apples();
            $applesTree->generation(rand(15, 25));

        } catch (ErrorException $e) {
            Yii::warning("Ошибка генератора дерева.");
        }

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
     *
     * На странице в приложении должны быть отображены все яблоки, (view)
     * которые на этой же странице можно сгенерировать (инициализация дерева)
     * в случайном кол-ве соответствующей кнопкой.
     */
    public function actionTask()
    {
        // генерация дерева на главной странице приложения
        if (Yii::$app->request->get()['generation'] == 'Y') {
            $this->actionGeneration();
            $this->redirect(array('apple/task'));
        }

        // отладочная страница, работает с нарушением MVC парадигмы
        if (Yii::$app->request->get()['abstract'] == 'Y') {
            return $this->actionAbstractApple();
        }

        // действие уронить яблоко
        if (!empty(Yii::$app->request->get()['drop']) && intval(Yii::$app->request->get()['drop']) > 0) {

            Apple::fallToGround(intval(Yii::$app->request->get()['drop']));
        }

        // действие откусить или полностью съесть яблоко
        if (
            !empty(Yii::$app->request->get()['eat']) && intval(Yii::$app->request->get()['eat']) > 0 &&
            !empty(Yii::$app->request->get()['size']) && floatval(Yii::$app->request->get()['size']) > 0
        ) {
            Apple::eat(intval(Yii::$app->request->get()['eat']), floatval(Yii::$app->request->get()['size']));

        } elseif (

            !empty(Yii::$app->request->get()['eat']) && intval(Yii::$app->request->get()['eat']) > 0 &&
            empty(Yii::$app->request->get()['size'])
        ) {
            Apple::eatAll(intval(Yii::$app->request->get()['eat']));
        }

        // действие очистить (испорченное)
        if (!empty(Yii::$app->request->get()['clean']) && intval(Yii::$app->request->get()['clean']) > 0) {

            Apple::removeApple(intval(Yii::$app->request->get()['clean']));
        }

        // действие постареть все упавшие
        if (!empty(Yii::$app->request->get()['skipTime']) && intval(Yii::$app->request->get()['skipTime']) > 0) {

            Apples::skipTime();
            $this->redirect(array('apple/task'));
        }

        $applesTree = new Apples();
        $deleted = $applesTree->clearTree('black'); // Пока висит на дереве - испортиться не может. Плохие (черные) удаляются при осмотре дерева.

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

    /**
     * @return string
     */
    public function actionAbstractApple()
    {
        $abstractAppleGreen = new Apple('green', 'onTree', 1.00);
        $abstractAppleRed = new Apple('red', 'falledToGround', 1.00);

        return $this->render('task/abstract', [
            'abstractAppleGreen' => $abstractAppleGreen,
            'abstractAppleRed' => $abstractAppleRed,
        ]);
    }
}
