<?php
namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\TableFile;

class TableFileSearch extends TableFile
{
    public function rules()
    {
        return [
            [['name', 'created_at'], 'string'],
            [['user_id', 'status'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = TableFile::find();

        if (isset($_REQUEST['pageSize'])) {
            Yii::$app->session['pageSize'] = $_REQUEST['pageSize'];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset(Yii::$app->session['pageSize']) ? Yii::$app->session['pageSize'] : Yii::$app->params['pageSize'],
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'created_at' => [
                    'asc' => [
                        'created_at' => SORT_ASC,
                    ],
                    'desc' => [
                        'created_at' => SORT_DESC,
                    ],
                    'default' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere([
            self::tableName() . '.user_id' => $this->user_id,
        ]);
        $query->andFilterWhere([
            self::tableName() . '.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->getAttribute('name')]);

        return $dataProvider;

    }
}