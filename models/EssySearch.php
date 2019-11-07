<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Essy;

/**
 * EssySearch represents the model behind the search form of `app\models\Essy`.
 */
class EssySearch extends Essy
{
    public $article;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'article_id'], 'integer'],
            [['title','article'], 'safe'],
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
        $query = Essy::find();
        $query->joinWith('article');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['article'] = [
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
            'article_id' => $this->article_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'articles.title', $this->article]);

        return $dataProvider;
    }
}
