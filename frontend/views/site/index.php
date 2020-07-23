<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$gridId = 'tablefile-grid';
?>

<div class="<?= $gridId ?>">
    <div class="box box-default">
        <div class="box-header">
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-plus"></i>', ['upload'],
                    [
                        'class' => 'btn btn-primary btn-sm',
                        'title' => 'Load table'
                    ]); ?>
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

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>