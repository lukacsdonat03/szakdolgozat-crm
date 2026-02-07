<?php

namespace app\modules\projects\models;

use app\base\Model;
use app\components\GlobalHelper;
use app\modules\users\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

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

    const STATUS_TODO = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_REVIEW = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_ON_HOLD = 4;
    const STATUS_CANCELLED = 5;


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
            [['title', 'description','project_id','status'], 'required'],
            [['description'], 'string'],
            [['due_date', 'created_at', 'updated_at', 'completed_at'], 'safe'],
            [['title'], 'string', 'max' => 126],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['assigned_to' => 'id']],
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

    public function behaviors(){
        return array_merge(
            parent::behaviors(),
            [
                [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                    'value' => function () {
                        return date('Y-m-d H:i:s');
                    }
                ]
            ]
        );
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){

            $this->created_by = Yii::$app->user->id;
            if($this->status == self::STATUS_COMPLETED){
                $this->completed_at = date('Y-m-d H:i:s');
            }else{
                $this->completed_at = null;
            }
            return true;
        }

        return false;
    }

    public static function getStatuses($key = null)
    {
        $statuses = [
            self::STATUS_TODO => 'Tennivaló',
            self::STATUS_IN_PROGRESS => 'Folyamatban',
            self::STATUS_REVIEW => 'Ellenőrzésre vár',
            self::STATUS_COMPLETED => 'Kész',
            self::STATUS_ON_HOLD => 'Felfüggesztve',
            self::STATUS_CANCELLED => 'Megszakítva',
        ];

        return $key !== null ? ($statuses[$key] ?? null) : $statuses;
    }

    public static function getStatusColors($key = null)
    {
        $colors = [
            self::STATUS_TODO => '#6c757d',
            self::STATUS_IN_PROGRESS => '#0dcaf0',
            self::STATUS_REVIEW => '#ffc107',
            self::STATUS_COMPLETED => '#198754',
            self::STATUS_ON_HOLD => '#fd7e14',
            self::STATUS_CANCELLED => '#dc3545',
        ];

        return $key !== null ? ($colors[$key] ?? '#6c757d') : $colors;
    }

    /**
     * Gets query for [[AssignedTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedto()
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

    public function getCreatedbyname(){
        $user = User::find()->where(['id' => $this->created_by])->one();
        return (!empty($user) && !empty($user->profile)) ? $user->profile->name : 'Nincs beállítva';
    }

    public function getSchedule(){
        return $this->hasOne(Schedule::class,['task_id' => 'id']);
    }

    public function getMessages(){
        return $this->hasMany(TaskMessage::class, ['task_id' => 'id'])
            ->where(['is_deleted' => 0])
            ->orderBy(['created_at' => SORT_ASC]);
    }
}
