<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

// var_dump('<pre>', Yii::$app->request->post());
?>

Root app page:
<a href="<?= Url::to(['apple/task'/*, 'id' => 100*/])?>"><?= Html::encode("apple-task page"); ?></a>

<br />

<?
if(is_array($apples)) {
    ?>
    <br />
    На дереве <?=count($apples)?> яблок(а) <?=($deleted >0)? ' (из них удалено '.$deleted.' черных)':''?>:
    <br />
    <?
    foreach ($apples as $apple) {
        echo 'id: ' . $apple['id'] . ', color: ' . $colors[$apple['colorId']-1]['color'] . ', status: ' . $status[$apple['statusId']-1]['status'] . '<br />';
    }
}
?>

<br />
<br />

<?php $form = ActiveForm::begin(['action' => '?r=apple/generation', 'method' => 'GET']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сгенерировать чистое дерево', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>

<!--@todo-->just-debug DM in view (to be clean or comment in releas):<br />
<?
var_dump('$apples<pre>', $apples);
var_dump('$colors<pre>', $colors);
var_dump('$status<pre>', $status);
