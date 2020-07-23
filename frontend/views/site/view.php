<?php

use yii\widgets\DetailView;
use common\models\User;

?>

<div class="box-body">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
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
        ],
        [
            'attribute' => 'status',
            'value' => function($model){return \common\models\TableFile::getStatusArray()[$model->status];},
        ],
    ]
]);
?>
</div>