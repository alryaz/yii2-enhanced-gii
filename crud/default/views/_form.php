<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \mootensai\enhancedgii\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
<?php
// @TODO : use namespace of foreign keys & widgets
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

<?php 
$pk = empty($generator->tableSchema->primaryKey) ? $generator->tableSchema->getColumnNames()[0] : $generator->tableSchema->primaryKey[0];
$modelClass = StringHelper::basename($generator->modelClass);
if ($generator->generateRelationsOnCreate){
    foreach ($relations as $name => $rel) {
        $relID = Inflector::camel2id($rel[1]);
        if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)) {
            echo "\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, \n"
                . "    'viewParams' => [\n"
                . "        'class' => '$rel[1]', \n"
                . "        'relID' => '$relID', \n"
                . "        'value' => \yii\helpers\Json::encode(\$model->$name),\n"
                . "        'isNewRecord' => (\$model->isNewRecord) ? 1 : 0\n"
                . "    ]\n"
                . "]);\n";
        }
    }
}
?>
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form well">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    
    <?= "<?= " ?>$form->errorSummary($model); ?>

<?php $behaviorColumns = ['created_at','created_by','updated_at','updated_by']; ?>

    <?php foreach ($generator->tableSchema->columns as $column) {
    if ((!in_array($column->name, $generator->skippedColumns)) &&
        (!in_array($column->name, $behaviorColumns)) &&
            !(($column->autoIncrement) && ($column->name === $pk))) {
        echo "    <?= " . $generator->generateActiveField($column->name, $generator->generateFK()) . " ?>\n\n";
    }
} ?>
<?php
if ($generator->generateRelationsOnCreate) {
    foreach ($relations as $name => $rel) {
        $relID = Inflector::camel2id($rel[1]);
        if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)) {
            echo "    <div class=\"form-group\" id=\"add-$relID\"></div>\n\n";
        }
    }
}
?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success']) ?>
        <?php if ($generator->cancelable): ?>
        <?= "<?= " ?>Html::a(Yii::t('app', 'Cancel'),['index'],['class'=> 'btn btn-danger']) ?>
<?php endif; ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
