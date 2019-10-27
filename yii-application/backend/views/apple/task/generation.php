<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
?>

Back to main app:
<a href="<?= Url::to(['apple/task'/*, 'id' => 100*/])?>"><?= Html::encode("apple-task page"); ?></a>

<br />

<?
if(is_array($apples)) {
    ?>
    <br />
    На дереве <?=count($apples)?> яблок(а):
    <br />
    <?
    foreach ($apples as $apple) {

        if($colors[$apple['colorId']-1]['color'] != $colors[count($colors)-1]['color']) {
            echo 'id: ' . $apple['id'] . ', color: ' . $colors[$apple['colorId']-1]['color'] . ', status: ' . $status[$apple['statusId']-1]['status'] . '<br />';
        } else {
            echo 'id: ' . $apple['id'] . ', color: ' . $colors[$apple['colorId']-1]['color'] . ', status: родилось черным, будет удалено при осмотре<br />';
        }
    }
}
?>


<br />
<br />

<?php $form = ActiveForm::begin(['action' => '?r=apple/task', 'method' => 'GET']) ?>

<div class="form-group">
    <?= Html::submitButton('Вернуться в к осмотру дерева', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
