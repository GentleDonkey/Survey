<?php 
require_once FS_PHP.'/DataMapperModel.php';

class Questionnaire extends DataMapperModel {
	
	/**
	 * Calculate the requested semester at any given time
	 * @param datetime $datetime
	 * @return int
	 */
	public static function fetchSemester($datetime){
	
		$year = $datetime -> format('Y');
		if ($datetime -> format('m') === "01" || $datetime -> format('m') === "02" || $datetime -> format('m') === "03" || $datetime -> format('m') === "04") {
			return $session_code = '' . $year . '1';
		} elseif ($datetime -> format('m') === "05" || $datetime -> format('m') === "06" || $datetime -> format('m') === "07" || $datetime -> format('m') === "08") {
			return $session_code = '' . $year . '5';
		} else {
			return $session_code = '' . $year . '9';
		}
	}
	
	/**
	 * gennerate Hash Code
	 * @param array $data
	 * @return string
	 */
	function gennerateHashCode($number){
		return hash('sha256', $number);
	}
	
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------About User--------------------------------------------------------------------------------*/
	/**
	 * check if the user exists
	 * @param string $user The Hash Code
	 * @return bool
	 */
	function checkUserExists($user){
	
		$user = parent::$db->clean($user);
		$sql = "SELECT COUNT(student_number)
				  FROM survey_student_list
				 WHERE email_link = '$user'";
		$data = parent::$db->query($sql);
		
		if($data['0']['COUNT(student_number)'] === "0"){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * check is it the first time student do survey at given semester
	 * @param string $user The Hash Code
	 * @return bool
	 */
	function checkFirstTime($user){
	
		$user = parent::$db->clean($user);
		$sql = "SELECT COUNT(*)
				  FROM survey_student_list
				 WHERE student_number = (SELECT student_number
										   FROM survey_student_list
										  WHERE email_link = '$user')
				   AND completed = '1'";
		$data = parent::$db->query($sql);
		
		if($data['0']['COUNT(*)'] === "0"){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * search student by Hash Code
	 * @param string $user The Hash Code
	 * @return array
	 */
	function fetchStudentByHashCode($user){
	
		$user = parent::$db->clean($user);
		$sql = "SELECT l.*, s.*, e.*
				  FROM survey_student_list l, survey_students s, survey_services e
				 WHERE email_link = '$user'
				   AND l.student_number = s.student_number
				   AND l.survey_sent_on_service_id = e.service_id";
	
		$data = parent::$db->query($sql);
	
		return $data;
	}
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------Generate questionnaire--------------------------------------------------------------------*/
	/**
	 * List all genneral Questionnaire
	 * @return array
	 */
	function listGenneralQuestionnaire () {
	
		$sql = "SELECT q.*
				  FROM survey_questions	q
				 WHERE q.question_id
				NOT IN (SELECT sq.question_id
						FROM survey_service_questions sq)
			  ORDER BY q.question_id";
	
		return parent::$db->query($sql);
	}
	
	/**
	 * List all Questionnaire for a particular SASS service
	 * @param int $serviceId The service id
	 * @return array
	 */
	function listParticularQuestionnaire ($serviceId) {
		
		$serviceId = parent::$db->clean($serviceId);
		$sql = "SELECT q.*
				  FROM survey_questions q
				  JOIN survey_service_questions sq
				    ON q.question_id = sq.question_id
				 WHERE sq.service_id = '$serviceId'
			  ORDER BY q.question_id";
		
		return parent::$db->query($sql);
	}
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------Adding into question_answer table---------------------------------------------------------*/
	/**
	 * Add single questionnaire answer
	 * @param int $id the question id
	 * @param int $data1 the answer id
	 * @param string $data2 The answer comment
	 * @return int
	 */
	function addSingleQuestionAnswer($id, $data1, $data2) {
	
		$id = parent::$db->clean($id);
		$data1 = parent::$db->clean($data1);
		$data2 = parent::$db->clean($data2);
	
		$keys = array('answered_question_id', 'question_id', 'answer_id', 'answered_question_comment');
		$data['question_id'] = $id;
		$data['answer_id'] = $data1;
		$data['answered_question_comment'] = $data2;
		$data = parent::$db->cleanAndPick($keys, $data);
	
		return parent::$db->insert('survey_question_answers', $data);
	}
	
	/**
	 * Get max question_id in questions_table
	 * @return int The max question_id
	 */
	function getQuestionNumber(){
	
		$sql = "SELECT MAX(q.question_id)
				  FROM survey_questions q";
		$result = parent::$db->query($sql);
	
		return $questionNumber = $result[0]['MAX(q.question_id)'];
	}
	
	/**
	 * Add all questionnaire answers
	 * @param array $data The answers data
	 * @return array
	 */
	function addQuestionAnswer($data) {
	
		$data = parent::$db->clean($data);
		$array = array();
		$questionNumber = $this -> getQuestionNumber();
	
		for($id=1; $id<=$questionNumber; $id++){
			if(isset($data['answerForQuestion' . $id . ''])){
				$array[] = $this -> addSingleQuestionAnswer($id, $data['answerForQuestion' . $id . ''], $data['commentForQuestion' . $id . '']);
			}
		}
		return $array;
	}
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------Adding into student_question_answer table-------------------------------------------------*/
	/**
	 * Add single student questionnaire
	 * @param int $id The qestionnaire id
	 * @param int $list_id represent one student
	 * @return bool
	 */
	function addSingleStudentQuestionAnswer($id, $list_id){
		
		$id = parent::$db->clean($id);
		$list_id = parent::$db->clean($list_id);
		
		$keys = array('info_id', 'answered_question_id', 'list_id');
		$data['answered_question_id'] = $id;
		$data['list_id'] = $list_id;
		$data = parent::$db->cleanAndPick($keys, $data);
		
		return parent::$db->insert('survey_student_question_answers', $data);
	}
	
	/**
	 * Add all student questionnaire
	 * @param array $id The questionnaires id
	 * @param int $list_id represent one student
	 * @return bool
	 */
	function addStudentQuestionAnswer($id, $list_id){
		
		$id = parent::$db->clean($id);
		$list_id = parent::$db->clean($list_id);
		foreach($id as $value){
			$this -> addSingleStudentQuestionAnswer($value, $list_id);
		}
		return true;
	}
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------updating student_list table---------------------------------------------------------------*/
	function updateStudentList($key){
		
		$key = static::$db->clean($key);		
		if (empty($key)) {
			throw new InvalidArgumentException('Cannot update setting without a key');
		}
		$datenow = date('Y-m-d H:i:s');
		return parent::$db->update('survey_student_list', array('completed' => 1, 'completed_on' => $datenow, 'updated_on' => $datenow), "list_id = '$key'");
	}
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	function checkOtherSurvey($user){
		
		$user = parent::$db->clean($user);
		$sql = "SELECT COUNT(email_link)
				  FROM survey_student_list
				 WHERE student_number = (SELECT student_number
										   FROM survey_student_list
										  WHERE email_link = '$user')
				   AND completed <> '1'";
		
		$data = parent::$db->query($sql);
		
		if($data['0']['COUNT(email_link)'] === "0"){
			return false;
		}else{
			return true;
		}
	}
	
	function fetchOtherSurvey($user){
		
		$user = parent::$db->clean($user);
		$sql = "SELECT l.*, s.*
				  FROM survey_student_list l, survey_services s
				 WHERE student_number = (SELECT student_number
										   FROM survey_student_list
										  WHERE email_link = '$user')
				   AND completed <> '1'
				   AND l.survey_sent_on_service_id = s.service_id";

		return parent::$db->query($sql);
	}
}





















?>