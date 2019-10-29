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
    На дереве <?= count($apples) ?> яблок(а) <?= ($deleted > 0) ? ' (удалено ' . $deleted . ' черных)' : '' ?>:
    <br/>
    <br/>
    <?
    foreach ($apples as $apple) {

        if ($apple['howLongFalled'] > 0) {
            echo '<span style="color: ' . $colors[$apple['colorId'] - 1]['color'] . '; padding: 0;">';
            echo 'Время на земле: ' . $apple['howLongFalled'] . ' час. ';
        }
        echo 'id: ' . $apple['id']
            . ', color: ' . $colors[$apple['colorId'] - 1]['color']
            . ', status: ' . $status[$apple['statusId'] - 1]['status']
            . (($status[$apple['statusId'] - 1]['status'] == 'falledToGround') ? ', dateFalls: ' . $apple['dateFalls'] : '')
            . ', size: ' . $apple['size'];

        echo ($status[$apple['statusId'] - 1]['status'] == 'onTree') ? ' <a href="' . Url::to(['apple/task', 'drop' => $apple['id']]) . '">' . Html::encode("уронить") . '</a>' : '';

        if ($status[$apple['statusId'] - 1]['status'] == 'falledToGround') {

            if ($apple['size'] == 1 && $colors[$apple['colorId'] - 1]['color'] == 'red') {
                echo ' <a href="' . Url::to(['apple/task', 'eat' => $apple['id']]) . '">' . Html::encode("съесть целиком") . '</a>, ';
            }
            if ($apple['size'] >= 0.5) {
                echo ' <a href="' . Url::to(['apple/task', 'eat' => $apple['id'], 'size' => 50]) . '">' . Html::encode("откусить половину (0.5)") . '</a>,';
            }
            if ($apple['size'] >= 0.25) {
                echo ' <a href="' . Url::to(['apple/task', 'eat' => $apple['id'], 'size' => 25]) . '">' . Html::encode("откусить четверть (0.25)") . '</a>';
            }
        }

        if ($apple['howLongFalled'] > 0) {
            echo '</span>';
        }

        echo '<br />';
    }
}
?>

<br/>

<? if (count($apples)) { ?>
    <?php $form = ActiveForm::begin(['action' => '?r=apple/task&skipTime=1', 'method' => 'GET']) ?>

    <div class="form-group">
        <?= Html::submitButton('Пропустить 1 час', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>
<? } ?>

<?php $form = ActiveForm::begin(['action' => '?r=apple/generation', 'method' => 'GET']) ?>

<div class="form-group">
    <?= Html::submitButton('Сгенерировать дерево на отдельной странице', ['class' => 'btn btn-primary']) ?>
    <a href="<?= Url::to(['apple/task', 'generation' => 'Y']) ?>"><?= Html::encode("либо сгенерировать чистое дерево прямо на этой странице"); ?></a>
    <br/>
    <br/>
    <a href="<?= Url::to(['apple/task', 'abstract' => 'Y']) ?>"><?= Html::encode("демонстрация работы модели через представление /backend/views/apple/task/abstract (Только для тестов!)"); ?></a>
</div>

<?php ActiveForm::end() ?>
