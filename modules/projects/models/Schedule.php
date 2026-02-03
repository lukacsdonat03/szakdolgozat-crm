<?php

namespace app\modules\projects\models;

use Yii;

/**
 * This is the model class for table "project_schedules".
 *
 * @property int $id Azonosító
 * @property int $task_id Feladat
 * @property string $start_date Kezdés
 * @property int|null $day_spread Napszám
 *
 * @property Task $task
 */
class Schedule extends \app\base\Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_schedules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day_spread'], 'default', 'value' => null],
            [['start_date',], 'required'],
            [['task_id', 'day_spread'], 'integer'],
            [['start_date'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'task_id' => 'Feladat',
            'start_date' => 'Kezdés',
            'day_spread' => 'Napszám',
        ];
    }

   public static function getSchedulesByDates($start = null, $end = null){
        if (empty($start) || empty($end)) {
            $start = date('Y-m-d', strtotime('monday this week'));
            $end = date('Y-m-d', strtotime('sunday this week'));
        }

        return self::find()
            ->joinWith('task')
            ->where(['between', 'start_date', $start, $end])
            ->andWhere(['assigned_to' => Yii::$app->user->id])
            ->all();
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public function getArrayForCalendar(){
        
        $events = [];
        $daySpread = $this->day_spread ?? 1;

        for ($i = 0; $i < $daySpread; $i++) {
            $events[] = $this->prepareCalendarEvent($i, $daySpread);
        }

        return $events;
    }

    protected function prepareCalendarEvent($dayIndex, $totalDays){

        $task = $this->task;
        $times = $this->calculateEventTimes($dayIndex, $totalDays);

        return [
            'id' => $this->task_id,
            'title' => $task->title,
            'start' => $times['start'],
            'end' => $times['end'],
            'color' => Task::getStatusColors($task->status),
            'extendedProps' => [
                'description' => $task->description,
                'status' => $task->status,
            ]
        ];
    }

    protected function calculateEventTimes($dayOffset, $totalDays){

        $hoursPerDay = $totalDays > 0 ? ($this->task->estimated_hours / $totalDays) : 0;
        $startTime = date('Y-m-d 08:00:00', strtotime($this->start_date . " +{$dayOffset} days"));
        $endTime = date('Y-m-d H:i:s', strtotime($startTime . " +{$hoursPerDay} hours"));

        return [
            'start' => $startTime,
            'end' => $endTime
        ];
    }

}
