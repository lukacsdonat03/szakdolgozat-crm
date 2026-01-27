<?php

namespace app\modules\projects\models;

use app\base\Model;
use app\modules\users\models\User;
use Yii;

/**
 * This is the model class for table "project_tasks".
 *
 * @property int $id Azonosító
 * @property int|null $project_id Projekt
 * @property int|null $assigned_to Hozzárendelve
 * @property string $title Név
 * @property string $description Leírás
 * @property int|null $status Státusz
 * @property int $priority Prioritás
 * @property string|null $due_date Határidő
 * @property int|null $estimated_hours Becsült óra
 * @property int $sort_order Sorrend
 * @property int|null $created_by Létrehozta
 * @property string|null $created_at Létrehozva
 * @property string|null $updated_at Módosítva
 * @property string|null $completed_at Elkészült
 *
 * @property User $assignedTo
 * @property Project $project
 */
class Task extends Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'assigned_to', 'status', 'due_date', 'estimated_hours', 'created_by', 'created_at', 'updated_at', 'completed_at'], 'default', 'value' => null],
            [['sort_order'], 'default', 'value' => 0],
            [['project_id', 'assigned_to', 'status', 'priority', 'estimated_hours', 'sort_order', 'created_by'], 'integer'],
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['due_date', 'created_at', 'updated_at', 'completed_at'], 'safe'],
            [['title'], 'string', 'max' => 126],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectProjects::class, 'targetAttribute' => ['project_id' => 'id']],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => UserUsers::class, 'targetAttribute' => ['assigned_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'project_id' => 'Projekt',
            'assigned_to' => 'Hozzárendelve',
            'title' => 'Név',
            'description' => 'Leírás',
            'status' => 'Státusz',
            'priority' => 'Prioritás',
            'due_date' => 'Határidő',
            'estimated_hours' => 'Becsült óra',
            'sort_order' => 'Sorrend',
            'created_by' => 'Létrehozta',
            'created_at' => 'Létrehozva',
            'updated_at' => 'Módosítva',
            'completed_at' => 'Elkészült',
        ];
    }

    /**
     * Gets query for [[AssignedTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(User::class, ['id' => 'assigned_to']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

}
