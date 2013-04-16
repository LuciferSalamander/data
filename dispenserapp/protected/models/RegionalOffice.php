<?php

/**
 * This is the model class for table "regional_office".
 *
 * The followings are the available columns in table 'regional_office':
 * @property integer $office_id
 * @property string $office_name
 *
 * The followings are the available model relations:
 * @property Pilot[] $pilots
 * @property Users[] $users
 * @property Waterpoints[] $waterpoints
 */
class RegionalOffice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegionalOffice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'regional_office';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('office_name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('office_id, office_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'pilots' => array(self::HAS_MANY, 'Pilot', 'regional_office_id'),
			'users' => array(self::HAS_MANY, 'Users', 'regional_office_id'),
			'waterpoints' => array(self::HAS_MANY, 'Waterpoints', 'regional_office_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'office_id' => 'Office',
			'office_name' => 'Office Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('office_id',$this->office_id);
		$criteria->compare('office_name',$this->office_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}