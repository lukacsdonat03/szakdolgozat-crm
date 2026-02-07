<?php

namespace app\modules\projects\models;

use app\modules\users\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project_task_messages".
 *
 * @property int $id
 * @property int $sender_id Küldő
 * @property int $receiver_id Címzett
 * @property string $content Tartalom
 * @property int $task_id Feladat
 * @property string|null $created_at Léterhozva
 * @property int $is_deleted Törölve
 *
 * @property User $receiver
 * @property User $sender
 * @property Task $task
 */
class TaskMessage extends \app\base\Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_task_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['sender_id', 'receiver_id', 'content', 'task_id'], 'required'],
            [['sender_id', 'receiver_id', 'task_id', 'is_deleted'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['receiver_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Küldő',
            'receiver_id' => 'Címzett',
            'content' => 'Tartalom',
            'task_id' => 'Feladat',
            'created_at' => 'Léterhozva',
            'is_deleted' => 'Törölve',
        ];
    }

    public function behaviors(){
        return array_merge(
            parent::behaviors(),
            [
                [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => false,
                    'value' => function () {
                        return date('Y-m-d H:i:s');
                    }
                ]
            ]
        );
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->sender_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }
    /**
     * Gets query for [[Receiver]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::class, ['id' => 'receiver_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
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

    public function getSendername(){
        $user = $this->sender;
        return (!empty($user->profile) ? $user->profile->name : $user->username); 
    }

    public function getReceivername(){
        $user = $this->receiver;
        return (!empty($user->profile) ? $user->profile->name : $user->username); 
    }

    public function softDelete(){
        $this->is_deleted = self::YES;
        return $this->save(false);
    }
}
