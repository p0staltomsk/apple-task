<?php

namespace app\models;

/**
 * Class Apple
 * @package app\models
 */
class Apple extends Apples
{
    public $color;

    /**
     * Apple constructor.
     * @param string $color
     * @param array $config
     */
    public function __construct($color = 'green', array $config = [])
    {
        $this->color = Colors::find()->where(['color' => $color])->asArray()->all()[0]['id'];
        // var_dump('<pre>', $this->color);
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
     * @return bool
     */
    public static function newApple()
    {
        $apple = new Apple();

        $apple->statusId = 1;
        $apple->colorId = rand(1, Colors::find()->orderBy('id')->count());
        $apple->dateCreated = date("Y-m-d H:m:s", mt_rand(time(), 2147385600));

        return $apple->save();
    }

    public function saveAbstractAppleToTree() {

        $apple = new Apple();

        $apple->statusId = 1;
        $apple->colorId = $this->color;
        $apple->dateCreated = date("Y-m-d H:m:s", time());

        return $apple->save();
    }

    public static function touchAppleOnTree($id)
    {

    }

    public static function fallToGround()
    {

    }

    public static function eat()
    {

    }
}
