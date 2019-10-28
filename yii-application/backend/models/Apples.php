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
    public function generation($bornCount = 0)
    {
        if ($bornCount == 0) {
            $bornCount = rand(15, 80);
        }

        $this->clearTree();

        for ($i = 1; $i <= $bornCount; $i++) {

            Apple::newApple();
        }
    }

    /**
     * @param string $color
     * @return int
     */
    public function clearTree($color = '')
    {
        if (empty($color)) {

            return Apples::deleteAll();

        } else {

            $findApples = Apples::find()->where(['colorId' => Colors::find()->where(['color' => $color])->asArray()->all()[0]['id']])->asArray()->all();

            Apples::deleteAll(['id' => $findApples]);

            return count($findApples);
        }
    }

    private static function getAllFalled()
    {
        $fallenApples = Apples::find()
            /*->andWhere(['not', ['howLongFalled' => null]])*/
            ->andWhere(['statusId' => Status::find()->where(['status' => 'falledToGround'])->asArray()->all()[0]['id']])
            ->all();

        foreach ($fallenApples as $item) {

            Apple::skipAppleTime($item['id']);
        }
    }

    public static function skipTime()
    {
        self::getAllFalled();
    }
}
