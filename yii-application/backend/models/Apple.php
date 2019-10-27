<?php

namespace app\models;

/**
 * Class Apple
 * @package app\models
 */
class Apple extends Apples
{
    public $color;
    public $colors;

    /**
     * Apple constructor.
     * @param string $color
     * @param array $config
     */
    public function __construct($color = 'green', array $config = [])
    {
        $this->color = $color;
        $this->colors = Colors::find()->orderBy('id')->asArray()->all();

        parent::__construct($config);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{apples}}';
    }

    public function saveAppleToTree() {

        $apple = new Apples();

        $apple->colorId = $this->color; // @todo либо связываь таблицы либо валидировать
        $apple->dateCreated = date("Y-m-d H:m:s", time());
        $apple->statusId = 1;
        $apple->quantity = 100;

        $apple->save();
    }
}
