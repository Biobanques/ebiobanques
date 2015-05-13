<?php

/**
 * EMongoUniqueValidator.php
 *
 * PHP version 5.2+
 *
 * @author		Dariusz Górecki <darek.krk@gmail.com>
 * @author		Invenzzia Group, open-source division of CleverIT company http://www.invenzzia.org
 * @copyright	2011 CleverIT http://www.cleverit.com.pl
 * @license		http://www.yiiframework.com/license/ BSD license
 * @version		1.3
 * @category	ext
 * @package		ext.YiiMongoDbSuite
 * @since		v1.1
 */

/**
 * @since v1.1
 */
class CustomMongoUniqueValidator extends CValidator
{
    public $allowEmpty = true;

    public function validateAttribute($object, $attribute) {
        $value = $object->{$attribute};
        if ($this->allowEmpty && ($value === null || $value === ''))
            return;

        $criteria = new EMongoCriteria;
        $criteria->{$attribute} = $value;

        $count = $object->model()->count($criteria);


        if ($count !== 0)
            if (!isset($object->_id) || $object->model()->find($criteria)->_id != $object->_id) {
                $this->addError(
                        $object, $attribute, Yii::t('yii', '{attribute} is not unique in DB.')
                );
            }
    }

}