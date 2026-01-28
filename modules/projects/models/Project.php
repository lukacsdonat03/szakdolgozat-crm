<?php

namespace app\modules\projects\models;

use app\modules\clients\models\Client;
use app\modules\users\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project_projects".
 *
 * @property int $id Azonosító
 * @property int $client_id Ügyfél
 * @property string $name Név
 * @property string|null $description Leírás
 * @property int|null $status_id Státusz
 * @property int $priority Prioritás
 * @property string $start_date Projekt kezdete
 * @property string $deadline Határidő
 * @property float|null $budget Költségvetési keret
 * @property int|null $created_by Létrehozta
 * @property string|null $created_at Létrehozva
 * @property string|null $updated_at Módosítva
 *
 * @property Client $client
 * @property User $createdBy
 * @property Task[] $projectTasks
 * @property Status $status
 */
class Project extends \yii\db\ActiveRecord
{

    public $taglist = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'status_id', 'budget', 'created_by', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['priority'], 'default', 'value' => 0],
            [['client_id', 'name', 'start_date', 'deadline'], 'required'],
            [['client_id', 'status_id', 'priority', 'created_by'], 'integer'],
            [['description'], 'string'],
            [['start_date', 'deadline', 'created_at', 'updated_at', 'taglist'], 'safe'],
            [['budget'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'client_id' => 'Ügyfél',
            'name' => 'Név',
            'description' => 'Leírás',
            'status_id' => 'Státusz',
            'priority' => 'Prioritás',
            'start_date' => 'Projekt kezdete',
            'deadline' => 'Határidő',
            'budget' => 'Költségvetési keret',
            'created_by' => 'Létrehozta',
            'created_at' => 'Létrehozva',
            'updated_at' => 'Módosítva',
            'taglist' => 'Címkék',
        ];
    }

    public function behaviors()
    {
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

        if (parent::beforeSave($insert)) {

            $this->created_by = Yii::$app->user->id;

            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!isset($this->taglist)) {
            return;
        }

        $newTagIds = array_filter((array)$this->taglist);

        $currentTagIds = ProjectTagRelation::find()
            ->select('tag_id')
            ->where(['project_id' => $this->id])
            ->column();

        $toDelete = array_diff($currentTagIds, $newTagIds);
        if (!empty($toDelete)) {
            ProjectTagRelation::deleteAll([
                'project_id' => $this->id,
                'tag_id' => $toDelete
            ]);
        }

        $toAdd = array_diff($newTagIds, $currentTagIds);
        if (!empty($toAdd)) {
            $rows = [];
            foreach ($toAdd as $tagId) {
                $rows[] = [$this->id, $tagId];
            }
            Yii::$app->db->createCommand()
                ->batchInsert(
                    ProjectTagRelation::tableName(),
                    ['project_id', 'tag_id'],
                    $rows
                )
                ->execute();
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->taglist = ArrayHelper::getColumn($this->tags,'tag_id');

    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedbyuser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[ProjectTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    public function getTags(){
        return $this->hasMany(ProjectTagRelation::class,['project_id' => 'id']);
    }

    public function getTagitems(){
        return $this->hasMany(Tag::class,['id' => 'tag_id'])->via('tags');
    }
}
