<?php
/**
 * A custom validator class which compares a end date with a start date (END should be after Start date).
 * @author Wenbin
 *
 */
class CompareStartEndDates extends CValidator{
	
	public $compare=null;
	public $pattern="yyyy-MM-dd";
	
	protected function validateAttribute($object, $attribute){
		$message=Yii::t('yii','{attribute} must be greater than "{compareValue}".');
		$compare=$this->compare;

        /*if (empty($object->attributes[$compare]) && empty($object->attributes[$attribute])) return;*/
        if ($object->attributes[$compare] == null && $object->attributes[$attribute] == null) return;

        Yii::log($object->attributes[$compare] . " " . $object->attributes[$attribute]);

		if (!isset($object->attributes[$attribute])) $object->addError($attribute,'An ' . $object->getAttributeLabel($attribute) . ' is required.');
		if ($compare==null) throw new CException('Compare value is required.');
		if (!isset($object->attributes[$compare])) $object->addError($compare,'A ' . $object->getAttributeLabel($compare) . ' is required.');
		
		if (!$object->hasErrors($attribute)) {
			$value=$object->attributes[$attribute];
			$compareValue=$object->attributes[$compare];
			$pattern=$this->pattern;
			if(CDateTimeParser::parse($value, $pattern) < CDateTimeParser::parse($compareValue, $pattern))
			{
				$params=array('{attribute}'=>$object->getAttributeLabel($attribute),'{compareValue}'=>$object->getAttributeLabel($compare));
				$object->addError($attribute,strtr($message,$params));
			}			
		}
	}
}