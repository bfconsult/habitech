<?php

/**
 * This is the model class for table "countries".
 *
 * The followings are the available columns in table 'countries':
 * @property string $id
 * @property string $iso
 * @property string $iso3
 * @property string $fips
 * @property string $country
 * @property string $continent
 * @property string $currency_code
 * @property string $currency_name
 * @property string $phone_prefix
 * @property string $postal_code
 * @property string $languages
 * @property string $geonameid
 *
 * The followings are the available model relations:
 * @property States[] $states
 */
class Countries extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Countries the static model class
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
		return 'countries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iso, iso3, fips, country, continent, currency_code, currency_name, phone_prefix, postal_code, languages, geonameid', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, iso, iso3, fips, country, continent, currency_code, currency_name, phone_prefix, postal_code, languages, geonameid', 'safe', 'on'=>'search'),
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
			'states' => array(self::HAS_MANY, 'States', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'iso' => 'Iso',
			'iso3' => 'Iso3',
			'fips' => 'Fips',
			'country' => 'Country',
			'continent' => 'Continent',
			'currency_code' => 'Currency Code',
			'currency_name' => 'Currency Name',
			'phone_prefix' => 'Phone Prefix',
			'postal_code' => 'Postal Code',
			'languages' => 'Languages',
			'geonameid' => 'Geonameid',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('iso3',$this->iso3,true);
		$criteria->compare('fips',$this->fips,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('continent',$this->continent,true);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('currency_name',$this->currency_name,true);
		$criteria->compare('phone_prefix',$this->phone_prefix,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('languages',$this->languages,true);
		$criteria->compare('geonameid',$this->geonameid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
                public function getWineCountries()
	{
	
               $allitems = Yii::app()->db->createCommand()
                        ->select('id, country')
                        ->from('countries')
                        ->where('`wineproducer`=1')
                       ->order('country ASC')
                        ->queryAll();
                return $allitems;
        }
}