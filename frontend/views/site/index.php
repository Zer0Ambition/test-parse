<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = "Table files";
$this->params['subtitle'] = "File list";
$this->params['breadcrumbs'][] = $this->title;

$gridId = 'tablefile-grid';
?>

<div class="<?= $gridId ?>">
    <div class="box box-default">
        <div class="box-header">
            <div class="pull-right">
                <?= Html::a('Upload file', ['upload'],
                    [
                        'class' => 'btn btn-primary btn-sm',
                        'title' => 'HTML table',
                        'style' => 'margin-bottom: 10px'
                    ]); ?>
            </div>  
        </div>
    </div>
        <div class="box-body">

            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'attribute' => 'created_at',
                            'value' => function ($model) {
                                $date = new DateTime($model->created_at);
                                return $date->format('d.m.Y H:i');
                            },
                            'filter' => false,
                        ],
                        'name',
                        [
                            'attribute' => 'user_id',
                            'value' => function($model){
                                if ($model->user_id) {
                                    $user = User::findOne($model->user_id);
                                    if ($user) {
                                        return $user->username;
                                    }
                                }
                            },
                            'filter' => Html::activeDropDownList(
                                $searchModel, 'user_id', ArrayHelper::map(User::find()->all(), 'id', 'username'), ['class' => 'form-control', 'prompt' => '']
                            )
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function($model){return \common\models\TableFile::getStatusArray()[$model->status];},
                            'filter' => Html::activeDropDownList(
                                $searchModel, 'status', \common\models\TableFile::getStatusArray(), ['class' => 'form-control', 'prompt' => '']
                            )
                        ],

                        ['class' => 'yii\grid\ActionColumn' ,
                            'template'=>'{view} {delete}',
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>