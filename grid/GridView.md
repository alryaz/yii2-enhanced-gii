Some GridView Tips
------------------


````php
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-reclamacao']],
        //Set a label for the default export menu
        'export' => [
            'label' => Yii::t('app', 'Page'),
            'fontAwesome' => false,
        ],
        'toolbar' => [
            [
                'content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                'class' => 'btn btn-default',
                'title' => Yii::t('app', 'Reset Filters')                ]),
            ],
            '{export}',
            //Your toolbar can include the additional full export menu
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => false,
                'dropdownOptions' => [
                    'label' => Yii::t('app', 'Full'),
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">'.Yii::t('app', 'Export All Data').'</li>',
                    ],
                ],
            ]) ,
            '{toggleData}',
        ],
        //Replace the pagination with the infinite scroll https://github.com/kop/yii2-scroll-pager
        'pager' => [
            'class' => \kop\y2sp\ScrollPager::className(),
            'container' => '.grid-view',
            'item' => '.kv-grid-table tbody tr',
            'enabledExtensions' => [
                \kop\y2sp\ScrollPager::EXTENSION_SPINNER,
            ],
        ],
    ]); ?>
````