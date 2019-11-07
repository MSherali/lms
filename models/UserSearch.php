<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $course;
    public $faculty;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'fullname', 'password_hash', 'password_reset_token', 'email', 'auth_key', 'gruppa', 'address', 'birthplace', 'phone', 'course','faculty', 'created_at', 'updated_at'], 'safe'],
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
        $query = User::find()->where(['<>','username','admin']);
        $query->joinWith('course');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [ 'updated_at' => SORT_DESC ]
            ]
        ]);

        $dataProvider->sort->attributes['course'] = [
            'asc' => ['courses.course' => SORT_ASC],
            'desc' => ['courses.course' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['faculty'] = [
            'asc' => ['courses.faculty' => SORT_ASC],
            'desc' => ['courses.faculty' => SORT_DESC],
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
            'status' => $this->status,
            //'course_id' => $this->course_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'gruppa', $this->gruppa])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'birthplace', $this->birthplace])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'courses.course', $this->course])
            ->andFilterWhere(['like', 'courses.faculty', $this->faculty]);

        return $dataProvider;
    }
}
