<?php
class FontHelper {
	public static function getDefault($name, $model) {
        $options = array(
            'helvetica' => Yii::t('global', 'Helvetica'),
            'dejavusansmono' => Yii::t('global', 'Dejavusansmono'),
            'dejavusanscondensed' => Yii::t('global','Dejavusanscondensed'),
        );
        return CHtml::activeDropDownList($model, $name, $options, array('class' => 'select form-control', 'empty' => Yii::t('global', '-- Please select font --')));
    }
}