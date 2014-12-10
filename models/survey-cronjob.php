<?php
/**
 * @author Zhiyan Qu
 */
class SurveyCronJobs extends DataMapperModel {

	/*------------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------update student list-----------------------------------------------------------------------*/
	/**
	 * fetch the students who went calendar two days ago
	 * @return array
	 */
	public function fetchCalendarList() {
		 
		$sql = "SELECT s.student_number, c.appointment_end, at.service_id
				  FROM survey_students s
			      JOIN (survey_calendar c LEFT JOIN survey_calendar_appointment_types at
				    					         ON c.appointment_type_id = at.appointment_type_id)
					ON s.student_number = c.student_number
				 WHERE c.appointment_end >= DATE_SUB(NOW(), INTERVAL 2 DAY)
				   AND c.appointment_end < DATE_SUB(NOW(), INTERVAL 1 DAY)
				   AND  s.student_number NOT IN (SELECT e.student_number FROM survey_emails_unsubscribed e)
			  ORDER BY s.student_number";
		 
		$data =  parent::$db->query($sql);
		return $data;
	}
	
	/**
	 * fetch the students who went card-visit two days ago
	 * @return array
	 */
	public function fetchCardVisitList() {
	
		$sql = "SELECT s.student_number, v.visit_date, v.service_id
				  FROM survey_students s
			 LEFT JOIN survey_student_card_visits v
					ON s.student_number = v.student_number
				 WHERE s.student_number IN (SELECT k.student_number
											  FROM survey_student_card_visits k
											 WHERE k.visit_date >= DATE_SUB(NOW(), INTERVAL 2 DAY)
											   AND k.visit_date < DATE_SUB(NOW(), INTERVAL 1 DAY))
				   AND s.student_number NOT IN (SELECT e.student_number FROM survey_emails_unsubscribed e)
			  ORDER BY s.student_number";
	
		return parent::$db->query($sql);
	}
	
	/**
	 * Calculate the requested semester at any given time
	 * @param datetime $datetime
	 * @return array
	 */
	public function fetchSemester($datetime){
	
		$datetime = DateTime::createFromFormat("Y-m-d H:i:s", $datetime);
		$year = $datetime -> format('Y');
		
		if ($datetime -> format('m') === "01" || $datetime -> format('m') === "02" || $datetime -> format('m') === "03" || $datetime -> format('m') === "04") {
			$session['session_en'] = '' . $year . ' Winter';
			$session['session_fr'] = '' . $year . ' hiver';
			$session['session_code'] = '' . $year . '1';
			$session['session_start'] = date("Y-m-d H:i:s",mktime(0,0,0,1,1,$year));
			$session['session_end'] = date("Y-m-d H:i:s",mktime(0,0,0,4,30,$year));
			$session['session_survey_expire'] = date("Y-m-d H:i:s",mktime(0,0,0,05,15,$year));
		} elseif ($datetime -> format('m') === "05" || $datetime -> format('m') === "06" || $datetime -> format('m') === "07" || $datetime -> format('m') === "08") {
			$session['session_en'] = '' . $year . ' Summer';
			$session['session_fr'] = '' . $year . ' été';
			$session['session_code'] = '' . $year . '5';
			$session['session_start'] = date("Y-m-d H:i:s",mktime(0,0,0,4,1,$year));
			$session['session_end'] = date("Y-m-d H:i:s",mktime(0,0,0,8,31,$year));
			$session['session_survey_expire'] = date("Y-m-d H:i:s",mktime(0,0,0,08,15,$year));
		} else {
			$session['session_en'] = '' . $year . ' Fall';
			$session['session_fr'] = '' . $year . ' tomber';
			$session['session_code']  = '' . $year . '9';
			$session['session_start'] = date("Y-m-d H:i:s",mktime(0,0,0,9,1,$year));
			$session['session_end'] = date("Y-m-d H:i:s",mktime(0,0,0,12,31,$year));
			$session['session_survey_expire'] = date("Y-m-d H:i:s",mktime(0,0,0,01,15,$year+1));
		}
		
		return $session;
	}
	
	/**
	 * gennerate Hash Code
	 * @param array $data
	 * @return string
	 */
	public function gennerateHashCode($number){
		return hash('sha256', $number);
	}

	/**
	 * check if the student/service in the list
	 * @param int $number the student number
	 * @param int $id the service id
	 * @return int
	 */
	public function studentExist($number, $id, $date){

		$session = $this->fetchSemester($date);
		$start = $session['session_start'];
		$expire = $session['session_survey_expire'];

		$sqll = "SELECT s.student_number
				  FROM survey_student_list s
				 WHERE s.student_number = " . $number . "
				   AND s.survey_sent_on_service_id = " . $id . "
			  ORDER BY s.student_number";
		
		$sql = "SELECT s.student_number
				  FROM survey_student_list s
				 WHERE s.student_number = $number
				   AND s.survey_sent_on_service_id = $id
				   AND s.survey_sent_on >= '$start'
				   AND s.survey_sent_on < '$expire'
			  ORDER BY s.student_number";
		
		$value = parent::$db->query($sql);

		return count($value);
	}
	
	/**
	 * add single student into student-list
	 * @param int $number the student number
	 * @param datetime $date the day student went to SASS
	 * @param int $id the service id
	 * @return array
	 */
	public function addSingleStudentToList($number, $date, $id){
		 
		$number = parent::$db->clean($number);
    	$date = parent::$db->clean($date);
    	$id = parent::$db->clean($id);
    	
    	$term = $this->fetchSemester($date);
    	$code = $this->gennerateHashCode($number . '' . $term['session_code'] . '' . $id);
    	
    	$keys = array('list_id', 'student_number', 'survey_sent', 'survey_sent_on', 'email_link', 'survey_sent_on_service_id', 'completed', 'completed_on', 'updated_on');
    	$data['student_number'] = $number;
    	$data['survey_sent'] = 0;
    	$data['survey_sent_on'] = $date;
    	$data['email_link'] = $code;
    	$data['survey_sent_on_service_id'] = $id;
    	$data['completed'] = 0;
    	$data['completed_on'] = NULL;
    	$data['updated_on'] = NULL;
    	$data = parent::$db->cleanAndPick($keys, $data);
    	
    	return parent::$db->insert('survey_student_list', $data);
	}
	
	/**
	 * add all students into student-list if not repeat
	 * @return array
	 */
	public function addStudentToList(){
		$calendar = $this->fetchCalendarList();
		foreach($calendar as $a){
			if($this->studentExist($a['student_number'], $a['service_id'], $a['appointment_end'])){
				continue;
			}else{
				$this->addSingleStudentToList($a['student_number'], $a['appointment_end'], $a['service_id']);
			}
		}
		$cardvisit = $this->fetchCardVisitList();
		foreach($cardvisit as $b){
			if($this->studentExist($b['student_number'], $b['service_id'], $b['visit_date'])){
				continue;
			}else{
				$this->addSingleStudentToList($b['student_number'], $b['visit_date'], $b['service_id']);
			}
		}
		return true;
	}
	/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	/**
	 * Runs all survey cron jobs
	 */
	public function runAllSurveyJobs() {
		echo microtime(true) . " Survey cron jobs started <br>\n";
		$this->notifyStudentsForSurveys();
		echo microtime(true) . " Survey cron jobs completed <br>\n";
	}
    
    /**
     * Notifies students to do the survey
     */
    final public function notifyStudentsForSurveys() {
        
    	$this->addStudentToList();
    	
        $sql = "SELECT DATE(sl.survey_sent_on) AS event_semester, s.student_email_prefix, sl.email_link, sl.list_id, 
                       CONCAT(s.student_first_name, ' ', s.student_last_name) AS student_name,
					   v.service_name_en, v.service_name_fr
                  FROM survey_student_list sl, survey_services v, survey_students s
                 WHERE sl.survey_sent = 0
        		   AND sl.survey_sent_on_service_id = v.service_id
        		   AND sl.student_number = s.student_number";
        $surveys = parent::$db->query($sql);
        
        if(!empty($surveys)) {
            
            require_once FS_VENDOR_BACKEND . '/swiftmailer/swift_required.php';
            $transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_SERVER_PORT);
            $mailer = Swift_Mailer::newInstance($transport);
            
            $subject = "Some French subject / Survey notification";
            
            foreach($surveys as $a) {
            	$html = '<p>(English message follows)</p>';
                    
                $html .= "<p>Bonjour {$a['student_name']},</p>";
                
                $html .= '<br>';

                $html .= '<p>Vous avez récemment utilisé les services offerts par le Service d’appui au succès scolaire.</p>';
                $html .= '<p>Afin de mesurer et d’améliorer la qualité de nos services, nous vous prions remplir le questionnaire suivant (environ 2 minutes):</p>';
                $html .= "<p><a href=" . "https://localhost/~GentleDonkey/Ventus-next/survey/questionnaire.php?user={$a['email_link']}" . ">Click here to access survey</a></p>";
                $html .= '<p>Toutes vos réponses resteront anonymes et confidentielles.</p>';
                $html .= '<p>Votre opinion est importante pour nous. Merci de prendre quelques minutes pour nous faire part de vos commentaires.</p>';
                
                $html .= '<br>';
                
                $html .= '<p>L’équipe du Service d’appui au succès scolaire (SASS)</p>';
                $html .= '<p>Université d\'Ottawa</p>';
                
                $html .= '<br>';
                
                $html .= '<small>Nous nous soucions de la protection de vos renseignements personnels.  À noter : pour chacun des services du SASS que vous consultez pendant une session, nous vous ferons parvenir un sondage à remplir. Cliquez <a>http://sass.uottawa.ca/sondage/desabonner</a>,  pour vous désabonner des courriels-sondage du SASS de façon PERMANENTE.</small>';
                    
                $html .= '<hr>';
                    
                $html .= "<p>Hello {$a['student_name']},</p>";
                
                $html .= '<br>';

                $html .= '<p>You recently used the services offered by the Student Academic Success Service (SASS).</p>';
                $html .= "<p>To help improve and measure the quality of your experience, please take a few moments to complete our brief survey questionnaire (about 2 minutes):</p>";
                $html .= "<p><a href=" . "https://localhost/~GentleDonkey/Ventus-next/survey/questionnaire.php?user={$a['email_link']}" . ">Click here to access survey</a></p>";
                $html .= '<p>All your answers will remain anonymous and confidential.</p>';
                $html .= '<p>Your opinion is important to us.  Thank you for taking the time to send us your feedback.</p>';
                
                $html .= '<br>';
                
                $html .= '<p>The Student Academic Success Service Team</p>';
                $html .= '<p>University of Ottawa</p>';
                
                $html .= '<br>';
                
                $html .= '<small>Your privacy is important to us.  Note: For each SASS service you have consulted during the semester, you will be invited to complete a survey.  Unsubscribe from SASS survey emails PERMANENTLY at <a>http://sass.uottawa.ca/survey/unsubscribe</a>. </small>';

                //Add troubleshooting footer
                $html .= "<hr><small>For internal use:" . base64_encode(" SENT " . date('Y-m-d H:i:s') . ' SCRIPT ' . $_SERVER['PHP_SELF']) . '</small>';
                
                if(isset($html)) {
                    $message = Swift_Message::newInstance()
                           ->setSubject($subject)
                           ->setFrom(EMAIL_ALIAS_NO_REPLY . EMAIL_ORG_STAFF_DOMAIN)
                           ->setTo($a['student_email_prefix'] . "@uottawa.ca")
                           ->setBody($html, 'text/html', 'utf-8');
                    
                    $mailer->send($message);
                    
                    //Update database so that reminder is not sent out repeatedly
                    $datenow = date('Y-m-d H:i:s');
                    parent::$db->update('survey_student_list', array('survey_sent' => '1', 'survey_sent_on' => $datenow), 'list_id = ' . $a['list_id']);

                    unset($html);
                }                
            }
        }
    }
}
