<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\ErrorException;

use yii\widgets\ActiveForm;

?>

    Back to main app:
    <a href="<?= Url::to(['apple/task']) ?>"><?= Html::encode("apple-task page"); ?></a>

<? /* @todo Только для тестов! */

// добавим два яблока и сохраним красное
try {

    echo '<br/><br/>яблоко abstractAppleGreen<br/>';
    echo 'осмотреть цвет: ' . $abstractAppleGreen->color . '<br />';
    echo 'осмотреть статус: ' . $abstractAppleGreen->status . '<br />';
    echo 'попытка откусить: ' . $abstractAppleGreen::eat($abstractAppleGreen->id, 50)['status'] . '<br />';
    echo 'осмотреть кол-во: ' . $abstractAppleGreen->size . '<br />' . '<br />';

    echo 'яблоко abstractAppleRed<br/>';

    echo 'осмотреть цвет: ' . $abstractAppleRed->color . '<br />';
    echo 'осмотреть статус: ' . $abstractAppleRed->status . '<br />';
    echo 'осмотреть кол-во: ' . $abstractAppleRed->size . '<br />';
    echo 'попытка откусить: ' . $abstractAppleRed::eat($abstractAppleRed->id, 50)['status'] . '<br />';
    echo 'осмотреть кол-во: ' . $abstractAppleRed->size . '<br />';

    $save = $abstractAppleRed->saveAbstractAppleToTree(); // сохраняем в БД
    echo '<br />сохраняем abstractAppleRed, lastId - ' . $save['lastId'];

    $open = $abstractAppleRed::getById($save['lastId']); // смотрим последний id

    $ukus = $open::eat($open->id, 50); // кусаем
    echo '<br />кусаем abstractAppleRed $open::eat($open->id, 50);';


    $open = $abstractAppleRed::getById($save['lastId']); // опять смотрим последний id
    echo '<br />осмотреть кол-во: ' . $open->getAttribute('size') . '<br />';

} catch (ErrorException $e) {
    Yii::warning("Ошибка сохранения объекта.");
}
?>

<br/>

<?php $form = ActiveForm::begin(['action' => '?r=apple/task', 'method' => 'GET']) ?>

    <div class="form-group">
        <?= Html::submitButton('Вернуться в к осмотру дерева', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>
