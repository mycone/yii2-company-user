<?php

namespace mycone\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mycone\users\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form about `mycone\users\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'depts_id', 'last_at', 'status'], 'integer'],
            [['username', 'auth_key', 'fullname', 'telphone', 'email', 'jobs', 'last_ip', 'avatar', 'remark'], 'safe'],
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
        $query = Employees::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'depts_id' => $this->depts_id,
            'last_at' => $this->last_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'telphone', $this->telphone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'jobs', $this->jobs])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
