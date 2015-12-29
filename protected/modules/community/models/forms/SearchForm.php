<?php
/**
 * This model is used for password reset form.
 *
 *@property String $searchString
 */
class SearchForm extends CFormModel
{
	public $searchString;
        public $programId;
        public $semesterId;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('searchString', 'required', 'message'=>'Cannot be blank'),
                        array('searchString', 'length', 'max' => 150, 'message'=>'Search string is too long'),
                        array('programId', 'default', 'setOnEmpty' => true, 'value' => NULL),
                        array('semesterId', 'default', 'setOnEmpty' => true, 'value' => NULL),
                        array('semesterId, programId', 'safe')
		);
	}

	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'searchString'=>Yii::t('forum', 'forum.search.text'),
		);
	}
}