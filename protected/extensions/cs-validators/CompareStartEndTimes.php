<?php
/**
 * A custom validator class which compares an end time with a start time.
 * When checkSame date flag is set to true, the validator will require the additional start/end date attributes to check whether both times are on the same day. Though checking end time >= start time is neccessary or ignored when start/end dates are not the same.
 * Otherwise, validation will check if start time <= end time all the time.
 * @author Wenbin
 *
 */
class CompareStartEndTimes extends CValidator
{

    public $compare = null;
    public $pattern = "hh:mm a";
    public $checkSameDate = true;
    public $startDate = null;
    public $endDate = null;
    public $datePattern = "yyyy-MM-dd";

    protected function validateAttribute($object, $attribute)
    {
        $message = Yii::t('yii', '{attribute} must be greater than "{compareValue}".');
        $compare = $this->compare;

        /*if (empty($object->attributes[$compare]) && empty($object->attributes[$attribute])) return;*/
        if ($object->attributes[$compare] == null && $object->attributes[$attribute] == null) return;

        if (!isset($object->attributes[$attribute])) $object->addError($attribute, 'An ' . $object->getAttributeLabel($attribute) . ' is required.');
        if ($compare == null) throw new CException('Compare value is required.');
        if (!isset($object->attributes[$compare])) $object->addError($compare, 'A ' . $object->getAttributeLabel($compare) . ' is required.');

        if (!$object->hasErrors(null)) {
            $value = $object->attributes[$attribute];
            $compareValue = $object->attributes[$compare];
            $pattern = $this->pattern;

            $startDate = $this->startDate;
            $endDate = $this->endDate;

            $checkTime = true;
            if ($this->checkSameDate) {
                if ($startDate == null) throw new CException('"startDate" is required.');
                if ($endDate == null) throw new CException('"endDate" is required.');
                if (!isset($object->attributes[$startDate])) $object->addError($startDate, 'Time requires a ' . $object->getAttributeLabel($startDate) . '.');
                if (!isset($object->attributes[$endDate])) $object->addError($endDate, 'Time requires an ' . $object->getAttributeLabel($endDate) . '.');

                if (!$object->hasErrors($attribute)) {

                    $startDateValue = $object->attributes[$startDate];
                    $endDateValue = $object->attributes[$endDate];
                    $datePattern = $this->datePattern;
                    $checkTime = (CDateTimeParser::parse($startDateValue, $datePattern) == CDateTimeParser::parse($endDateValue, $datePattern));


                    if ($checkTime) {
                        if (CDateTimeParser::parse($value, $pattern) <= CDateTimeParser::parse($compareValue, $pattern)) {
                            $params = array('{attribute}' => $object->getAttributeLabel($attribute), '{compareValue}' => $object->getAttributeLabel($compare));
                            $object->addError($attribute, strtr($message, $params));
                        }
                    }
                }
            }
        }
    }
}