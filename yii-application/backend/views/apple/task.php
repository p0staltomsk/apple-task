<?php
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
?>

Root app page:
<a href="<?= Url::to(['apple/task'])?>"><?= Html::encode("apple-task page"); ?></a>

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
        <?= Html::submitButton('Сгенерировать чистое дерево на отдельной странице', ['class' => 'btn btn-primary']) ?>
        <a href="<?= Url::to(['apple/task', 'generation' => 'Y'])?>"><?= Html::encode("либо сгенерировать на этой странице"); ?></a>
    </div>

<?php ActiveForm::end() ?>
