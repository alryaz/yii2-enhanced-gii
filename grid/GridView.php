<?php
/**
 * Created by PhpStorm.
 * User: Almir
 * Date: 15/06/2016
 * Time: 11:59
 */

namespace mootensai\enhancedgii\grid;

use Yii;
use yii\helpers\Html;
use kartik\export\ExportMenu;

class GridView extends \kartik\grid\GridView
{
    public $pjax  = true;
    public $hover = true;
    public $responsiveWrap = false;
    public $headerRowOptions = ['class'=>'kartik-sheet-style'];
    public $filterRowOptions = ['class'=>'kartik-sheet-style'];
    public $panelHeadingTitle;
    public $toggleDataOptions = [
        'minCount' => 100,
        'maxCount' => 1000,
    ];

    public function init()
    {
        if (!$this->panel) {

            $this->panel = [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-th-list"></span>  ' . Html::encode($this->getView()->title),
                'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]),
                'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('app', 'Reset Filters'), ['index'], ['class' => 'btn btn-info']),
            ];
        }

        if ($this->panelHeadingTitle) {
                $this->panel['heading'] = $this->panelHeadingTitle;
        }

        //Check if is modified
        if ($this->toolbar == ['{toggleData}','{export}']) {

            $this->toolbar = [
                [
                    'content' =>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('app', 'Reset Filters')]),
                ],
                '{export}',
                '{toggleData}',
            ];
        }

        if (!$this->exportConfig) {

            $this->exportConfig = [
                GridView::EXCEL => [],
                GridView::HTML => [],
                GridView::PDF => [
                    'config' => [
                        'destination' => \kartik\mpdf\Pdf::DEST_DOWNLOAD,
                        'methods' => [
                            'SetHeader' => [Yii::$app->name . '|' . Yii::t('app', 'Exportação de Dados') . '|' . date('d/m/Y H:i:s', time())],
                            'SetFooter' => ['|{PAGENO}/{nb}|'],
                        ],
                    ],
                ],
            ];
        }

        if (!$this->export) {
            $this->export =  ['target' => ExportMenu::TARGET_SELF];
        }

        if (!$this->pager) {
            $this->pager = ['firstPageLabel' => Yii::t('app','First'), 'lastPageLabel' => Yii::t('app','Last')];
        }

        parent::init();
    }
}


