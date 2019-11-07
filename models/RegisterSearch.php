<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Register;

/**
 * RegisterSearch represents the model behind the search form of `app\models\Register`.
 */
class RegisterSearch extends Register
{
    public $fullname;
    public $course;
    public $faculty;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'exam', 'essy', 'task', 'behaviors'], 'integer'],
            [['created_at','fullname','course','faculty'], 'safe'],
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
        $query = Register::find();
        $query->joinWith('user');
        $query->leftJoin('courses','users.course_id=courses.id');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['fullname'] = [
            'asc' => ['user.fullname' => SORT_ASC],
            'desc' => ['user.fullname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['faculty'] = [
            'asc' => ['courses.faculty' => SORT_ASC],
            'desc' => ['courses.faculty' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['course'] = [
            'asc' => ['courses.course' => SORT_ASC],
            'desc' => ['courses.course' => SORT_DESC],
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
            'exam' => $this->exam,
            'essy' => $this->essy,
            'task' => $this->task,
            'behaviors' => $this->behaviors,

            self::tableName().'.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'users.fullname', $this->fullname])
            ->andFilterWhere(['like', 'courses.course', $this->course])
            ->andFilterWhere(['like', 'courses.faculty', $this->faculty]);

        return $dataProvider;
    }
}
