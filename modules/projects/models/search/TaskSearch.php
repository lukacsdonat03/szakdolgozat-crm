<?php

namespace app\modules\projects\models\search;

use app\components\GlobalHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\projects\models\Task;

/**
 * TaskSearch represents the model behind the search form of `app\modules\projects\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'assigned_to', 'status', 'priority', 'estimated_hours', 'sort_order', 'created_by','is_deleted'], 'integer'],
            [['title', 'description', 'due_date', 'created_at', 'updated_at', 'completed_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'assigned_to' => $this->assigned_to,
            'status' => $this->status,
            'priority' => $this->priority,
            'estimated_hours' => $this->estimated_hours,
            'sort_order' => $this->sort_order,
            'created_by' => $this->created_by,
            'is_deleted' => Task::NO,
          /*   'created_at' => $this->created_at,
            'updated_at' => $this->updated_at, */
        ]);

        if ($this->due_date) {
            $this->due_date = str_replace('.','-',$this->due_date);
            $query->andFilterWhere(['like', 'due_date', $this->due_date]);
        }

        if ($this->completed_at) {
            $this->completed_at = str_replace('.','-',$this->completed_at);
            $query->andFilterWhere(['like', 'completed_at', $this->completed_at]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
