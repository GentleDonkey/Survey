<?php

require_once FS_PHP.'/DataMapperModel.php';

/**
 * @author Zhiyan Qu
 */
class Questions extends DataMapperModel {
    
    /**
     * List all services
     * @return array
     */
	function listAllServ(){
		$sql = "SELECT *
				  FROM survey_services";
		return parent::$db->query($sql);
	}
	
    /**
     * List all questions
     * @param int $id the service id (0 is for genneral questions)
     * @return array
     */
    function listAllQues($id) {
    	$priority = parent::$db->clean($priority);
    	
    	if(!ctype_digit($id)) {
    		throw new InvalidArgumentException('Service ID must be numeric.');
    	}else{
    		if($id == 0){
    			$sql = "SELECT q.*
				  	      FROM survey_questions	q
				 	 	 WHERE q.question_id
						NOT IN (SELECT sq.question_id
							      FROM survey_service_questions sq)
				   	   	   AND question_priority <> 0
			  	  	  ORDER BY q.question_priority";
    		}else{
    			$sql = "SELECT q.question_id, q.question_content_en, q.question_content_fr, q.question_priority, sq.service_id
    					  FROM survey_questions q, survey_service_questions sq
    					 WHERE q.question_id = sq.question_id
    					   AND sq.service_id = ' $id '
    					   AND q.question_priority <> 0
    				  ORDER BY q.question_priority ASC";
    		}
    	}
                            
        return parent::$db->query($sql);
    }
    
    /**
     * List deleted questions
     * @param int $id the service id (0 is for genneral questions)
     * @return array
     */
    function listDelQues($id) {
    	$priority = parent::$db->clean($priority);
    	 
    	if(!ctype_digit($id)) {
    		throw new InvalidArgumentException('Service ID must be numeric.');
    	}else{
    		if($id == 0){
    			$sql = "SELECT q.*
				  	      FROM survey_questions	q
				 	 	 WHERE q.question_id
						NOT IN (SELECT sq.question_id
							      FROM survey_service_questions sq)
				   	   	   AND question_priority = 0
			  	  	  ORDER BY q.question_priority";
    		}else{
    			$sql = "SELECT q.question_id, q.question_content_en, q.question_content_fr, q.question_priority, sq.service_id
    			FROM survey_questions q, survey_service_questions sq
    			WHERE q.question_id = sq.question_id
    			AND sq.service_id = ' $id '
    			AND q.question_priority = 0
    			ORDER BY q.question_priority ASC";
    		}
    	}
    
    	return parent::$db->query($sql);
    }
    
    /**
     * Update the priority of questions
     * @param array $priority The new order of questions
     */
    function updatePriority($priority) {
    	$priority = parent::$db->clean($priority);
    	echo "inside update";
    	if(!empty($priority[order])){
    		foreach($priority[order] as $key=>$prio){
    			$data = array('question_priority' => $key+1);
    			parent::$db->update('survey_questions', $data, "question_id = '$prio'");
    		}
    	}
    	if(!empty($priority[delete])){
    		foreach($priority[delete] as $prio){
    			$data = array('question_priority' => '0');
    			parent::$db->update('survey_questions', $data, "question_id = '$prio'");
    		}
    	}
    }
    
}
























