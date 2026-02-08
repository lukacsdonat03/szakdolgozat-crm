<?php

namespace app\modules\messages\models;

use app\modules\users\models\User;
use Yii;

/**
 * This is the model class for table "messages_message".
 *
 * @property int $id Azonosító
 * @property int $sender_id Küldő
 * @property int|null $receiver_id Címzett (opcionális)
 * @property int|null $reply_to_id Válasz (opcionális)
 * @property string $content Üzenet
 * @property string|null $created_at Küldve
 * @property int $is_deleted Törölve
 *
 * @property Message[] $messages
 * @property User $receiver
 * @property Message $replyTo
 * @property User $sender
 */
class Message extends \app\base\Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_id', 'reply_to_id', 'created_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['sender_id', 'content'], 'required'],
            [['sender_id', 'receiver_id', 'reply_to_id', 'is_deleted'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['reply_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::class, 'targetAttribute' => ['reply_to_id' => 'id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['receiver_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'sender_id' => 'Küldő',
            'receiver_id' => 'Címzett (opcionális)',
            'reply_to_id' => 'Válasz (opcionális)',
            'content' => 'Üzenet',
            'created_at' => 'Küldve',
            'is_deleted' => 'Törölve',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['reply_to_id' => 'id']);
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
     * Gets query for [[ReplyTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplyto()
    {
        return $this->hasOne(Message::class, ['id' => 'reply_to_id']);
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

}
