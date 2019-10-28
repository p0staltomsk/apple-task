<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

?>

Root app page:
<a href="<?= Url::to(['apple/task']) ?>"><?= Html::encode("apple-task page"); ?></a>

<br/>

<?
if (is_array($apples)) {
    ?>
    <br/>
    На дереве <?= count($apples) ?> яблок(а) <?= ($deleted > 0) ? ' (из них удалено ' . $deleted . ' черных)' : '' ?>:
    <br/>
    <br/>
    <?
    foreach ($apples as $apple) {

        echo 'id: ' . $apple['id']
            . ', color: ' . $colors[$apple['colorId'] - 1]['color']
            . ', status: ' . $status[$apple['statusId'] - 1]['status']
            . ', size: ' . $apple['size'];

        echo ($status[$apple['statusId'] - 1]['status'] == 'onTree') ? ' <a href="'.Url::to(['apple/task', 'drop' => $apple['id']]).'">'.Html::encode("уронить").'</a>' : '';
        echo ($status[$apple['statusId'] - 1]['status'] == 'falledToGround') ? ' 
            <a href="'.Url::to(['apple/task', 'eat' => $apple['id']]).'">'.Html::encode("съесть целиком").'</a>, 
            <a href="'.Url::to(['apple/task', 'eat' => $apple['id'], 'size' => 0.5]).'">'.Html::encode("откусить половину (0.5)").'</a>, 
            <a href="'.Url::to(['apple/task', 'eat' => $apple['id'], 'size' => 0.25]).'">'.Html::encode("откусить четверть (0.25)").'</a>
        ' : '';

        echo ($status[$apple['statusId'] - 1]['status'] == 'spoiledRotten') ? ' <a href="'.Url::to(['apple/task', 'clean' => $apple['id']]).'">'.Html::encode("очистить (испорченное)").'</a>' : '';

        echo '<br />';
    }
}
?>

<br/>

<?php $form = ActiveForm::begin(['action' => '?r=apple/generation', 'method' => 'GET']) ?>

<div class="form-group">
    <?= Html::submitButton('Сгенерировать чистое дерево на отдельной странице', ['class' => 'btn btn-primary']) ?>
    <a href="<?= Url::to(['apple/task', 'generation' => 'Y']) ?>"><?= Html::encode("либо сгенерировать на этой странице"); ?></a> <br />
    <a href="<?= Url::to(['apple/task', 'abstract' => 'Y']) ?>"><?= Html::encode("демонстрация работы модели через представление (Только для тестов!)"); ?></a>
</div>

<?php ActiveForm::end() ?>
