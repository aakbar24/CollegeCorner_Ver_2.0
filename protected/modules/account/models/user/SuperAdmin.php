<?php
class SuperAdmin extends Admin{
	
	const USER_GROUP_ID=6;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search($excludeUserId=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
	
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('t.user_group_id',$this->user_group_id);
		$criteria->compare('is_notify',$this->is_notify);
		$criteria->compare('is_active',$this->is_active);
        $criteria->compare('is_verified',$this->is_verified);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		
		if($excludeUserId!=null){
			$criteria->addCondition('t.user_id <> :excludeUserId');
			$criteria->params[':excludeUserId']=$excludeUserId;
		}
		
		$criteria->with=array(
				'userGroup'=>array(
						'joinType'=>'INNER JOIN',
		));

        $sort=array(
            'defaultOrder'=>'is_active DESC, is_verified DESC, t.user_group_id ASC, date_created DESC, date_created DESC, username ASC',
        );

		return $this->relatedSearch(
				$criteria,
            array('sort'=>$sort)
		);
	}
}