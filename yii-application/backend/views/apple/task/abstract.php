<?php

use yii\helpers\Html;
use yii\helpers\Url;

use app\models\Apple;

?>
    Back to main app:
    <a href="<?= Url::to(['apple/task']) ?>"><?= Html::encode("apple-task page"); ?></a>

    <br/>
    <br/>

<? /* @todo Только для тестов! */

$abstractApple = new Apple('red', 'falledToGround', 0.75);

    echo 'цвет:' . $abstractApple->color . '<br />';
    echo 'статус:' . $abstractApple->status . '<br />';
    echo 'кол-во:' . $abstractApple->size . '<br />';

    echo '<br />статус сохранения в БД:' . $abstractApple->saveAbstractAppleToTree() . '<br />';
