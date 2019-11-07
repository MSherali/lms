<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Exam;
use app\models\ExamDetail;

/**
 * ExamSearch represents the model behind the search form of `app\models\Question`.
 */
class ExamSearch extends Exam
{
    public $title;
    public $baho;
    public $fullname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id','article_id'], 'integer'],
            [['started_at', 'finished_at','title','fullname','baho'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Exam::find()->joinWith(['article','user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->sort->attributes['fullname'] = [
            'asc' => ['users.fullname' => SORT_ASC],
            'desc' => ['users.fullname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['title'] = [
            'asc' => ['article.title' => SORT_ASC],
            'desc' => ['article.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'article_id' => $this->article_id,
        ]);

        $query->andFilterWhere(['like', 'article.title', $this->title])
            ->andFilterWhere(['like', 'users.fullname', $this->fullname]);

        return $dataProvider;
    }
}
