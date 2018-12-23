<?php

use yii\helpers\Inflector;

/* @var $generator \mootensai\enhancedgii\crud\Generator */
$tableSchema = $generator->getDbConnection()->getTableSchema($relations[3]);
$fk = $generator->generateFK($tableSchema);
echo "<?php\n";
?>
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

Pjax::begin();
$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => '<?= $relations[1]; ?>',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
<?php foreach ($tableSchema->getColumnNames() as $attribute) : 
    $column = $tableSchema->getColumn($attribute);
    if (!in_array($attribute, $generator->skippedColumns) && $attribute != $relations[5]) {
        echo "        " . $generator->generateTabularFormField($attribute, $fk, $tableSchema) . ",\n";
    }
endforeach; ?>
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<?= $generator->generateIcon('trash'); ?>', '#', ['title' =>  <?= $generator->generateString('Delete') ?>, 'onClick' => 'delRow<?= $relations[1]; ?>(' . $key . '); return false;', 'id' => '<?= Inflector::camel2id($relations[1]) ?>-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => '<?= $generator->generateIconForTable($relations[$generator::REL_TABLE]) ?>' . <?= $generator->generateString(Inflector::camel2words($relations[1])) ?>,
            'type' => GridView::TYPE_INFO,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<?= $generator->generateIcon('plus') ?>' . <?= $generator->generateString('Add Row') ?>, ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRow<?= $relations[1]; ?>()']),
        ]
    ]
]);
Pjax::end();
?>
