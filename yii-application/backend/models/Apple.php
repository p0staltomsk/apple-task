<?php

namespace app\models;

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
        $this->color    = $color;
        $this->status   = $status;
        $this->size     = $size;

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

        $apple->statusId    = 1;
        $apple->colorId     = rand(1, Colors::find()->orderBy('id')->count());
        $apple->dateCreated = date("Y-m-d H:m:s", mt_rand(time(), 2147385600));
        $apple->size        = 1.0;

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

        $apple->statusId    = $this->status;
        $apple->colorId     = $this->color;
        $apple->dateCreated = date("Y-m-d H:m:s", time());
        $apple->size        = $this->size;

        return $apple->save();
    }

    public function fallToGround()
    {

    }

    public function eat($part = 0.25)
    {

    }

    public function eatAll()
    {

    }

    private function convertObjectToSave()
    {
        $this->color    = Colors::find()->where(['color' => $this->color])->asArray()->all()[0]['id'];
        $this->status   = Status::find()->where(['status' => $this->status])->asArray()->all()[0]['id'];
        $this->size     = (float)$this->size;
    }
}
