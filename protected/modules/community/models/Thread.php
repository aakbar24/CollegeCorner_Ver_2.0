<?php

/**
 * This is the model class for table "{{thread}}".
 *
 * The followings are the available columns in table '{{thread}}':
 * @property integer $post_item_id
 * @property string $program_code
 * @property integer $college_id
 * @property integer $program_id
 * @property integer $semester_id
 * @property string $attachment
 *
 * The followings are the available model relations:
 * @property Reply[] $replies
 * @property PostItem $postItem
 * @property CollegeProgram $college
 * @property CollegeProgram $program
 * @property Semester $semester
 */
class Thread extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Thread the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{thread}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('college_id, program_id, semester_id', 'required'),
            array('post_item_id, college_id, program_id, semester_id', 'numerical', 'integerOnly' => true),
            array('program_code', 'length', 'max' => 20, 'allowEmpty' => true),
            array('attachment', 'length', 'max' => 100),
            array('attachment', 'file', 'types' => 'jpg, gif, png, txt, zip, doc, docx, pdf, docx, ppt, pptx, xls, xlsx', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Attachment has to be smaller than 2MB', 'allowEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('post_item_id, program_code, college_id, program_id, semester_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'replies' => array(self::HAS_MANY, 'Reply', 'post_item_id'),
            'postItem' => array(self::BELONGS_TO, 'PostItem', 'post_item_id'),
            'complaint' => array(self::HAS_MANY, 'Complaint', 'post_item_id'),
            'college' => array(self::BELONGS_TO, 'College', 'college_id'),
            'program' => array(self::BELONGS_TO, 'Program', 'program_id'),
            'semester' => array(self::BELONGS_TO, 'Semester', 'semester_id'),
            'numReplies' => array(self::STAT, 'Reply', 'post_item_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'post_item_id' => 'Post Item',
            'program_code' => 'Program Code',
            'college_id' => 'College',
            'program_id' => 'Program',
            'semester_id' => 'Semester',
            'attachment' => 'Attachment',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($collegeId = null, $is_active = true, $reported = false) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('postItem', 'college', 'program');
        $criteria->compare('postItem.title', $this->post_item_id, true);
        $criteria->compare('postItem.is_active', $this->post_item_id);
        $criteria->compare('program_code', $this->program_code, true);
        $criteria->compare('college.college_id', $this->college_id);
        $criteria->compare('program.program_id', $this->program_id);
        $criteria->compare('semester_id', $this->semester_id);

        if ($collegeId != null) {
            $criteria->addCondition('t.college_id = :collegeId');
            $criteria->params[':collegeId'] = $collegeId;
        }

        if (!$is_active) {
            $criteria->addCondition('postItem.is_active = :isActive');
            $criteria->params[':isActive'] = $is_active;
        }
        
        if ($reported) {
            $criteria->with = array('postItem', 'college', 'program', 'complaint');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterFind() {
        parent::afterFind();

        if (!$this->program_code)
            $this->program_code = 'N / A';
    }

    protected function afterDelete() {
        parent::afterDelete();

        $this->postItem->delete();
        Yii::log(CVarDumper::dumpAsString("Post Item Mirror deleted: " . $this->post_item_id));
        PostItemSearch::model()->deleteAllByAttributes(array('post_item_id' => $this->post_item_id));
        Yii::log('Thread Path: ' . getcwd());

        if (!empty($this->attachment))
            unlink(Yii::app()->modulePath . '/community/files/' . $this->attachment . "_" . $this->post_item_id);
    }

    public static function getThreadsByProgram($collegeId) {
        $q = 'SELECT v.post_item_id as last_thread_id, v.count as thread_count, v.reply_count, v.title as last_thread_title, v.date_created AS last_posted, p.program_id, p.program_name
FROM tbl_program p 
INNER JOIN tbl_college_program tcp ON p.program_id=tcp.program_id AND tcp.college_id=:collegeId 
LEFT JOIN (
			SELECT tbl_post_item.post_item_id, tbl_post_item.title, tbl_post_item.date_created, lastT.program_id, lastT.college_id, lastT.count, lastT.reply_count
			FROM tbl_post_item 
			INNER JOIN(
						SELECT max(date_created) as date_created, countT.program_id, countT.college_id, countT.count, countT.reply_count
						FROM tbl_post_item 
						INNER JOIN tbl_thread ON tbl_post_item.post_item_id = tbl_thread.post_item_id
						INNER JOIN (
									SELECT count(tbl_thread.post_item_id) as count, college_id, program_id, sum(reply_count) as reply_count
									FROM tbl_thread 
									INNER JOIN tbl_post_item ON tbl_post_item.post_item_id = tbl_thread.post_item_id
									LEFT OUTER JOIN (
													SELECT tbl_reply.post_item_id, count(reply_id) as reply_count FROM tbl_reply WHERE tbl_reply.is_active=1 GROUP BY tbl_reply.post_item_id
													) countR ON tbl_thread.post_item_id = countR.post_item_id
									WHERE college_id=:collegeId 
									AND tbl_post_item.is_active=1 
									GROUP BY college_id, program_id 
									) countT ON countT.program_id=tbl_thread.program_id 
						
						WHERE tbl_thread.college_id=:collegeId 
						AND is_active=1 
						GROUP BY tbl_thread.program_id 
						) lastT ON lastT.date_created=tbl_post_item.date_created 
			WHERE post_type_id=7 ) v ON tcp.program_id=v.program_id AND tcp.college_id=v.college_id 
ORDER BY p.program_id asc';

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);
        $threadResult = $cmd->query();

        return $threadResult;
    }

    public static function getThreadsBySemester($collegeId, $programId) {

        $q = 'SELECT v.title as last_thread_title, v.post_item_id as last_thread_id, v.date_created as last_posted_date, v.count as thread_count, v.reply_count, semester_name, tbl_semester.semester_id 
FROM tbl_semester 
LEFT JOIN (
			SELECT lastT.semester_id, tbl_post_item.post_item_id, tbl_post_item.title, tbl_post_item.date_created, lastT.count, lastT.reply_count
			FROM tbl_post_item 
			INNER JOIN(
						SELECT max(date_created) as date_created, countT.semester_id, countT.count, countT.reply_count
						FROM tbl_post_item 
						INNER JOIN tbl_thread ON tbl_post_item.post_item_id = tbl_thread.post_item_id
						INNER JOIN (
									SELECT count(tbl_thread.post_item_id) as count, semester_id, sum(reply_count) as reply_count
									FROM tbl_thread 
									INNER JOIN tbl_post_item ON tbl_post_item.post_item_id = tbl_thread.post_item_id
									LEFT OUTER JOIN (
													SELECT tbl_reply.post_item_id, count(reply_id) as reply_count FROM tbl_reply WHERE tbl_reply.is_active=1 GROUP BY tbl_reply.post_item_id
													) countR ON tbl_thread.post_item_id = countR.post_item_id
									WHERE college_id=:collegeId and program_id=:programId
									AND tbl_post_item.is_active=1 
									GROUP BY college_id, program_id, semester_id
									) countT ON countT.semester_id=tbl_thread.semester_id 
						
						WHERE tbl_thread.college_id=:collegeId and tbl_thread.program_id=:programId
						AND is_active=1 
						GROUP BY tbl_thread.semester_id 
						) lastT ON lastT.date_created=tbl_post_item.date_created 

			WHERE post_type_id=7) v on v.semester_id=tbl_semester.semester_id 
ORDER BY tbl_semester.semester_id asc';

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);
        $cmd->bindParam(':programId', $programId, PDO::PARAM_INT);
        $threadResult = $cmd->query();

        return $threadResult;
    }

    public static function getThreads($collegeId, $programId, $semesterId) {
        $q = 'SELECT 
	thread_id, 
	title, 
	program_code, 
	DATE_FORMAT(date_created, "%m/%d/%Y %h:%i%p") AS date_created, 
	(SELECT message
		FROM tbl_reply 
		WHERE post_item_id = v_thread.thread_id 
		AND date_created = (SELECT MAX(date_created) 
								FROM tbl_reply 
								WHERE post_item_id = v_thread.thread_id
								AND is_active = 1
								AND college_id = :collegeId)
	) AS latest_reply,
	(SELECT count(*) 
		FROM tbl_reply 
		WHERE post_item_id = v_thread.thread_id
		AND is_active = 1
		AND college_id = :collegeId
	) AS reply_count
FROM v_thread
WHERE is_active = 1 
AND college_id = :collegeId
AND semester_id = :semesterId
AND program_id = :programId
ORDER BY date_created DESC;
';

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);
        $cmd->bindParam(':programId', $programId, PDO::PARAM_INT);
        $cmd->bindParam(':semesterId', $semesterId, PDO::PARAM_INT);
        $threadResult = $cmd->query();

        return $threadResult;
    }

    public static function getLatestReplies($userId, $days = 1) {
        $q = 'SELECT 
	thread_id, 
	title, 
	DATE_FORMAT(date_created, "%m/%d/%Y %h:%i%p") AS date_created, 
	(SELECT message
		FROM tbl_reply 
		WHERE post_item_id = v_thread.thread_id 
		AND date_created = (SELECT MAX(date_created) 
								FROM tbl_reply 
								WHERE post_item_id = v_thread.thread_id
								AND is_active = 1
								AND user_id = :userId)
	) AS latest_reply,
	(SELECT count(*) 
		FROM tbl_reply 
		WHERE post_item_id = v_thread.thread_id
		AND is_active = 1
		AND user_id = :userId
	) AS reply_count,
        (SELECT MAX(DATE_FORMAT(date_created, "%m/%d/%Y %h:%i%p")) 
		FROM tbl_reply 
		WHERE post_item_id = v_thread.thread_id
		AND is_active = 1
		AND user_id = :userId
                AND date_created between DATE_SUB(NOW(), INTERVAL :timespan DAY) AND NOW()
	) AS reply_date
FROM v_thread
WHERE is_active = 1
AND user_id = :userId 
ORDER BY reply_date DESC
';

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':userId', $userId, PDO::PARAM_INT);
        $cmd->bindParam(':timespan', $days, PDO::PARAM_INT);
        $threadResult = $cmd->query();

        return $threadResult;
    }

    public static function getLatestRepliesSnippet($userId, $days = 1) {

        $q=' 
SELECT
	thread_id AS id,
	title,
	program_name,
	program_code,
	program_id,
	semester_name,
	semester_id,
	z.reply_date
FROM v_thread INNER JOIN (
		SELECT DATE_FORMAT(MAX(date_created), "%m/%d/%Y %h:%i%p") as reply_date, post_item_id 
		FROM tbl_reply 
		WHERE user_id=:userId AND is_active = 1 
			AND date_created 
			BETWEEN DATE_SUB(NOW(), INTERVAL :timespan DAY) AND NOW() GROUP BY post_item_id
	) z ON v_thread.thread_id=z.post_item_id
WHERE is_active = 1
AND user_id = :userId
ORDER BY reply_date';
        /* $q = 'SELECT
	thread_id AS id,
	title,
	program_name,
	program_code,
	program_id,
	semester_name,
	semester_id,
        (SELECT MAX(DATE_FORMAT(date_created, "%m/%d/%Y %h:%i%p"))
		FROM tbl_reply
		WHERE post_item_id = v_thread.thread_id
		AND is_active = 1
		AND user_id = :userId
                AND date_created between DATE_SUB(NOW(), INTERVAL :timespan DAY) AND NOW()
	) AS reply_date
FROM v_thread
WHERE is_active = 1

ORDER BY reply_date DESC
'; */

/*        $q = 'SELECT
	thread_id AS id,
	title,
	program_name,
	program_code,
	program_id,
	semester_name,
	semester_id,
	z.reply_date
FROM v_thread INNER JOIN (SELECT (DATE_FORMAT(date_created, "%m/%d/%Y %h:%i%p")) AS reply_date, post_item_id
		FROM tbl_reply
		WHERE is_active = 1
		AND user_id = :userId
                AND date_created between DATE_SUB(NOW(), INTERVAL :timespan DAY) AND NOW()
	) z ON z.reply_date IS NOT NULL AND z.post_item_id = thread_id
WHERE is_active = 1
AND user_id = :userId
ORDER BY reply_date DESC
';*/

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':userId', $userId, PDO::PARAM_INT);
        $cmd->bindParam(':timespan', $days, PDO::PARAM_INT);

        $count = $cmd->query()->rowCount;
        
        return new CSqlDataProvider($cmd, array('params' => array(':userId'=> $userId, ':timespan' => $days), 'totalItemCount'=>$count,  'pagination'=>array(
            'pageSize'=>10,
        ),));
    }

    public static function getUserThreads($userId) {
        $q = "SELECT
        thread_id,
	title, 
        DATE_FORMAT(date_created, '%m/%d/%Y %h:%i%p') AS date_created,
	program_name,
        program_id,
	semester_name,
        semester_id,
        program_code
FROM v_thread
WHERE user_id = :userId
ORDER BY date_created DESC; 
";


        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':userId', $userId, PDO::PARAM_INT);
        $threadResult = $cmd->query();

        Yii::log($threadResult->getRowCount());

        return $threadResult;
    }

    public static function getTodaysThreads($collegeId) {
        $q = "SELECT
        thread_id,
	title, 
        DATE_FORMAT(date_created, '%m/%d/%Y %h:%i%p') AS date_created,
	program_name,
        program_id,
	semester_name,
        semester_id,
        program_code,
        (SELECT count(*) 
		FROM tbl_reply 
		WHERE post_item_id = v_thread.thread_id
		AND is_active = 1
		AND college_id = :collegeId
	) AS reply_count
FROM v_thread
WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 DAY)
AND college_id = :collegeId
ORDER BY date_created DESC; 
";

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);

        return  $cmd->query();

    }

    public static function getTodaysThreadsSnippet($collegeId)
    {
        Yii::log('College ID: ' . $collegeId);

        $count=Yii::app()->db->createCommand(
            'SELECT COUNT(*) FROM v_thread
WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 DAY)
AND college_id = :collegeId'
        )->queryScalar(array(':collegeId' => $collegeId));

        $q = "SELECT
        thread_id AS id,
	title,
        DATE_FORMAT(date_created, '%m/%d/%Y %h:%i%p') AS date_created,
	program_name,
        program_id,
        semester_id,
        semester_name,
        program_code
FROM v_thread
WHERE date_created > DATE_SUB(NOW(), INTERVAL 1 DAY)
AND college_id = :collegeId
ORDER BY date_created DESC
";

        $cmd = Yii::app()->db->createCommand($q);

        return new CSqlDataProvider($cmd, array('params' => array(':collegeId'=> $collegeId), 'totalItemCount'=>$count,  'pagination'=>array(
            'pageSize'=>10,
        ),));
    }

    public function searchTopics($string, $collegeId, $progId = null, $semesterId = null) {
        $q = "SELECT v.thread_id AS thread_id,
            DATE_FORMAT(v.date_created, '%m/%d/%Y %h:%i%p') AS date_created,
            v.title, 
            v.program_name, 
            v.program_id,
            v.semester_name,
            v.semester_id,
            v.program_code,
            (SELECT count(*) 
		FROM tbl_reply 
		WHERE post_item_id = v.thread_id
		AND is_active = 1
		AND college_id = :collegeId
	) AS reply_count
            FROM `tbl_post_item_search` AS s INNER JOIN v_thread AS v ON v.thread_id = s.post_item_id 
            WHERE MATCH (s.title, s.description) AGAINST (:string)";

        if (!empty($progId))
            $q .= " AND v.program_id=:programId";

        if (!empty($semesterId))
            $q .= " AND v.semester_id=:semesterId";

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);
        $cmd->bindParam(':string', $string, PDO::PARAM_STR);

        if (!empty($progId))
            $cmd->bindParam(':programId', $progId, PDO::PARAM_INT);

        if (!empty($semesterId))
            $cmd->bindParam(':semesterId', $semesterId, PDO::PARAM_INT);

        Yii::log($cmd->getText());

        $threadResult = $cmd->query();

        return $threadResult;
    }

    public function getPostsDataInThread($threadId) {
        $cmd = Yii::app()->db->createCommand('SELECT COUNT(*) FROM `tbl_reply` WHERE post_item_id = :threadId');
        $cmd->bindParam(':threadId', $threadId, PDO::PARAM_INT);
        $count = $cmd->queryScalar();

        $q = "SELECT
            reply_id AS id,
            tbl_reply.is_active,
            message,
            child_reply,
            DATE_FORMAT(tbl_reply.date_created, '%m/%d/%Y %h:%i%p') AS date_created,
            tbl_user.username,
            tbl_user.profile_image,
            tbl_user.user_group_id,
            tbl_user.user_id,
            DATE_FORMAT(tbl_user.date_created, '%m/%d/%Y') AS register_date
FROM `tbl_reply`
LEFT JOIN v_thread ON post_item_id = thread_id
LEFT JOIN tbl_user ON tbl_user.user_id = tbl_reply.user_id
WHERE thread_id = :threadId
ORDER BY tbl_reply.date_created 
";

        $dp = new CSqlDataProvider($q, array(
            'totalItemCount' => $count,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $dp->params = array(':threadId' => $threadId);
        return $dp;
    }

    public function getThreadInfoById($id) {
        $q = "SELECT 
	title, 
        description,
        attachment,
        username,
        user_id,
        user_group_id,
        profile_image,
        DATE_FORMAT(register_date, '%m/%d/%Y') AS register_date,
        DATE_FORMAT(date_created, '%m/%d/%Y %h:%i%p') AS date_created,
	program_name,
        program_id,
	semester_name,
        semester_id
FROM v_thread
WHERE thread_id = :threadId 
";

        $cmd = Yii::app()->db->createCommand($q);
        $cmd->bindParam(':threadId', $id, PDO::PARAM_INT);
        $threadResult = $cmd->queryRow();

        return $threadResult;
    }

    public function save($runValidation = true, $attributes = null, $postItem = null) {

        if ($this->isNewRecord) {
            if ($postItem != null && $postItem->primaryKey != null) {
                $this->post_item_id = $postItem->primaryKey;
                return parent::save($runValidation, $attributes);
            } else {
                throw new CException('A post item is required');
            }
        } else {
            return parent::save($runValidation, $attributes);
        }
    }

}