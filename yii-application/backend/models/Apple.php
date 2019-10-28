<?php

namespace app\models;

use Yii;

/**
 * Class Apple
 * @package app\models
 */
class Apple extends Apples
{
    public $color;
    public $status;
    public $size;

    /**
     * Apple constructor.
     * @param string $color
     * @param string $status
     * @param float $size
     * @param array $config
     */
    public function __construct($color = 'green', $status = 'onTree', $size = 1.0, array $config = [])
    {
        $this->color = $color;
        $this->status = $status;
        $this->size = $size;

        parent::__construct($config);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{apples}}';
    }

    /**
     * @param $id
     * @return null|static
     */
    public static function getById($id)
    {
        return Apple::findOne($id);
    }

    /**
     * @return bool
     */
    public static function newApple()
    {
        $apple = new Apple();

        $apple->statusId = 1;
        $apple->colorId = rand(1, Colors::find()->orderBy('id')->count());
        $apple->dateCreated = date("Y-m-d H:m:s", mt_rand(time(), 2147385600)); // годно до 2038г
        $apple->size = 1.0;

        return $apple->save();
    }

    /**
     * Сохнанить абстрактное яблоко в БД
     * с текущим временем создания,
     * кастомным цветом и выбранным статусом (на дереве / на земле / испорченное)
     * колличеством целостности
     * @return bool
     */
    public function saveAbstractAppleToTree()
    {
        self::convertObjectToSave();

        $apple = new Apple();

        $apple->statusId = $this->status;
        $apple->colorId = $this->color;
        $apple->dateCreated = date("Y-m-d H:m:s", time());
        $apple->setAttribute('size', $this->size);

        return ['status' => $apple->save(), 'lastId' => Yii::$app->db->getLastInsertID()];
    }

    /**
     * @param $id
     * @return array|void
     */
    public static function fallToGround($id)
    {
        if ($apple = Apple::findOne($id)) {

            $falledStatus = Status::find()->where(['status' => 'falledToGround'])->asArray()->all()[0]['id'];

            if ($apple->getAttribute('statusId') != $falledStatus) {

                $apple->dateFalls = date("Y-m-d H:m:s", time());
                $apple->statusId = $falledStatus;
                $apple->howLongFalled = 0;

                return ['status' => $apple->save()];

            } else {

                Yii::warning("Яблоко с id " . $id . " уже упало.");
                return ['status' => 'falled alredy'];
            }

        } else {

            Yii::warning("Яблоко с id " . $id . " не найдено.");
            return ['status' => 'not found'];
        }
    }

    public static function skipAppleTime($id)
    {

        if ($apple = Apple::getById($id)) {

            $needSkeep = floatval($apple->getAttribute('howLongFalled') + 1);

            if ($needSkeep >= 5) {

                return ['status' => Apple::spoiledRotten($id)];

            } else {

                $apple->setAttribute('howLongFalled', $needSkeep);

                return $apple->save();
            }
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public static function spoiledRotten($id)
    {
        if ($apple = Apple::findOne($id)) {
            $apple->setAttribute('colorId', Colors::find()->where(['color' => 'black'])->asArray()->all()[0]['id']);

            return $apple->save();
        }
    }

    /**
     * @param $id
     * @param $part
     * @return array
     */
    public static function eat($id, $part)
    {
        if ($apple = Apple::findOne($id)) {

            if ($apple['statusId'] != Status::find()->where(['status' => 'onTree'])->asArray()->all()[0]['id']) {

                $apple->setAttribute('size', ($apple->getAttribute('size') - floatval('0.' . $part)));

                $saveStatus = $apple->save();

                if ($apple->getAttribute('size') <= 0) {

                    $removeStatus = self::removeApple($id);
                }

                return ['status' => $saveStatus, 'removeStatus' => $removeStatus];

            } else {
                Yii::warning("Яблоко с id " . $id . " нельзя кусать с дерева.");
            }

        } else {

            Yii::warning("Яблоко с id " . $id . " не найдено.");
            return ['status' => 'DB: not found'];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public static function eatAll($id)
    {
        if (Apple::getById($id)['statusId'] != Status::find()->where(['status' => 'onTree'])->asArray()->all()[0]['id']) {
            return ['removeStatus' => self::removeApple($id)];
        } else {
            Yii::warning("Яблоко с id " . $id . " нельзя есть на дереве.");
        }
    }

    /**
     * @param $id
     * @return false|int
     */
    public static function removeApple($id)
    {
        if ($apple = Apple::findOne($id)) {

            return $apple->delete();

        } else {

            Yii::warning("Яблоко с id " . $id . " уже удалено.");
            return false;
        }
    }

    private function convertObjectToSave()
    {
        $this->color = Colors::find()->where(['color' => $this->color])->asArray()->all()[0]['id'];
        $this->status = Status::find()->where(['status' => $this->status])->asArray()->all()[0]['id'];
        $this->size = (float)$this->size;
    }
}
