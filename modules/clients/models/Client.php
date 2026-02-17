<?php

namespace app\modules\clients\models;

use app\modules\projects\models\Project;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "client_clients".
 *
 * @property int $id Azonosító
 * @property string $name Név
 * @property string $company Vállalat neve
 * @property string $email E-mail cím
 * @property string $phone Telefonszám
 * @property string|null $tax_number Adószám
 * @property string|null $address Cím
 * @property string|null $notes Megjegyzés
 * @property int $is_deleted
 *
 * @property Project[] $projectProjects
 */
class Client extends \app\base\Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tax_number', 'address', 'notes'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['name', 'company', 'email', 'phone'], 'required'],
            [['name', 'email', 'address'], 'string', 'max' => 126],
            [['company'], 'string', 'max' => 255],
            [['email'],'email'],
            [['is_deleted'],'integer'],
            [['phone', 'tax_number'], 'string', 'max' => 32],
            [['notes'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'name' => 'Név',
            'company' => 'Vállalat neve',
            'email' => 'E-mail cím',
            'phone' => 'Telefonszám',
            'tax_number' => 'Adószám',
            'address' => 'Cím',
            'notes' => 'Megjegyzés',
        ];
    }

    /**
     * Gets query for [[ProjectProjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectProjects()
    {
        return $this->hasMany(Project::class, ['client_id' => 'id']);
    }

    public static function getClientsForSelect($addEmpty = false, $order = false)
    {
        $result = [];
        $query = static::find();
        if(!empty($order)){
            $query->orderBy([$order => SORT_ASC]);
        }else{
            $query->orderBy(['name' => SORT_ASC]);
        }
        
        $items = $query->all();
        if(!empty($items)){
            foreach($items as $item){
                $postfix = !empty($item->company) ? " (". $item->company .") " : "";
                $result[$item->id] = $item->name . $postfix;
            }
        }

        if($addEmpty === true){
            $result = ArrayHelper::merge([0 => 'Nincs'],$result);
        }

        return $result;
    }

}
