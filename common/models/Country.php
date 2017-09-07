<?php

namespace common\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $population
 * @property string $flag_img
 */
class Country extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'population'], 'required'],
            [['population'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 128],
            [['flag_img'], 'string', 'max' => 255],
            [['flag_img'], 'required', 'on' => ['update']],
            ['flag_img', 'string', 'max' => 10, 'when' => function($model, $attribute) {
                return Yii::$app->user->isGuest;
            }, 'whenClient' => "function(attribute, value) { return false; }"],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    public function scenarios() {
        $merged_scenarios = ArrayHelper::merge(
            parent::scenarios(),
            [
                self::SCENARIO_CREATE => ['name', 'population', 'code', 'flag_img'],
                self::SCENARIO_UPDATE => ['name', 'population', 'code', 'flag_img'],
            ]);

        return $merged_scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'population' => 'Population',
            'flag_img' => 'Flag Img',
        ];
    }
}
