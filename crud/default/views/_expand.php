<?php

/* @var $this yii\web\View */
/* @var $generator \mootensai\enhancedgii\crud\Generator */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
?>
<?= "<?php" ?>

use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
    [
        'label' => '<?= $generator->generateIconForTable($generator->tableName) ?>' . Html::encode(<?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>),
        'content' => $this->render('_detail', [
            'model' => $model,
        ]),
    ],
<?php foreach ($relations as $name => $rel): ?>
    <?php if ($rel[2] && isset($rel[3]) && !in_array($name, $generator->skippedRelations)): ?>
    [
        'label' => '<?= $generator->generateIconForTable($rel[$generator::REL_TABLE]) ?>' . Html::encode(<?php $relName = Inflector::camel2words($rel[1]); echo $generator->generateString($rel[$generator::REL_IS_MULTIPLE] ? Inflector::pluralize($relName) : $relName); ?>),
        'content' => $this->render('_data<?= $rel[1] ?>', [
            'model' => $model,
            'row' => $model-><?= $name ?>,
        ]),
    ],
    <?php endif; ?>
<?php endforeach; ?>
];
echo TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false,
    'navType' => 'nav-pills',
    'class' => 'tes',
    'pluginOptions' => [
        'bordered' => true,
        'sideways' => true,
        'enableCache' => false
        //        'height' => TabsX::SIZE_TINY
    ],
    'pluginEvents' => [
        "tabsX.click" => "function(e) {setTimeout(function(e){
                if ($('.nav-tabs > .active').next('li').length == 0) {
                    $('#prev').show();
                    $('#next').hide();
                } else if($('.nav-tabs > .active').prev('li').length == 0){
                    $('#next').show();
                    $('#prev').hide();
                }else{
                    $('#next').show();
                    $('#prev').show();
                };
                console.log(JSON.stringify($('.active', '.nav-tabs').html()));
            },10)}",
    ],
]);
?>
