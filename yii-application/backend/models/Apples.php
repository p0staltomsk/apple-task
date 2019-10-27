<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Apples
 * @package app\models
 */
class Apples extends ActiveRecord
{
    /**
     * @param int $bornCount
     *
     * Сгенерировать чистое дерево
     * цвет (устанавливается при создании объекта случайным)
     * дата появления (устанавливается при создании объекта случайным unixTmeStamp) до 2038 года
     */
    public function generation($bornCount = 0) {

        if($bornCount == 0) {
            $bornCount = rand(15, 80);
        }

        $this->clearTree();

        $colors = Colors::find()->orderBy('id')->asArray()->all();

        for ($i = 1; $i <= $bornCount; $i++) {

            $apple = new Apples();

            $apple->colorId = rand(1, count($colors));
            $apple->dateCreated = date("Y-m-d H:m:s", mt_rand(time(), 2147385600));
            $apple->statusId = 1;
            $apple->quantity = 100;

            $apple->save();
        }
    }

    /**
     * @param string $color
     * @return int
     */
    public function clearTree($color = '') {

        if(empty($color)) {

            return Apples::deleteAll();

        } else {

            $findColor = Colors::find()->where(['color' => 'black'])->asArray()->all();
            $findApples = Apples::find()->where(['colorId' => $findColor[0]['id']])->asArray()->all();

            Apples::deleteAll(['id' => $findApples]);

            return count($findApples);
        }
    }
}
