<style scoped>@import url('includes/css/questionnaire.css');</style>

<!--BEGIN MAIN BODY CONTENT-->

<h1><?php $l10n->_e('title'); ?></h1>

<div id="normal-content">
	<form action="questionnaire.php?page=add&user=<?php echo $user; ?>" method="post" autocomplete='off'>
		<section id='questionnaire'> 
			<header>
        		<h3><?php $l10n->_e('QuestionnaireTitle'); ?></h3>
        		<div>
                	<p>
                		<?php $l10n->_e('helloSASS1');?>
                		<b><?php echo ' ' . $student['0']['student_first_name'] . ' ' . $student['0']['student_last_name']; ?></b> 
                		<?php $l10n->_e('helloSASS2');?>
                		<b><?php echo ' ' . $student['0']['service_name_en']; ?></b>
                		<?php $l10n->_e('helloSASS3');?>
                	</p>
                </div>
        	</header>
 
        	<?php if($model -> checkFirstTime($_GET['user'])){
            	foreach ($genneral as $a) {                               
                	echo '<div class="row">' . 
                  			'<label name="question[' . $a['question_id'] . ']" visibility="hidden">' . $a['question_id'] . '</label>' .
                  			'<span class="left-question">' . $a['question_content_en'] .  '</span>' .
                    		'<span class="buttonset">' .
                        		'<input type="radio" id="radio1ForQuestion' . $a['question_id'] . '" name="answerForQuestion' . $a['question_id'] . '" value="1"><label for="radio1ForQuestion' . $a['question_id'] . '">'; 
                        		$l10n->_e('1stLevelAnswer'); 
                          		echo '</label>' .
                            	'<input type="radio" id="radio2ForQuestion' . $a['question_id'] . '" name="answerForQuestion' . $a['question_id'] . '" value="2"><label for="radio2ForQuestion' . $a['question_id'] . '">'; 
                            	$l10n->_e('2ndLevelAnswer'); 
                              	echo '</label>' .
                            	'<input type="radio" id="radio3ForQuestion' . $a['question_id'] . '" name="answerForQuestion' . $a['question_id'] . '" value="3"><label for="radio3ForQuestion' . $a['question_id'] . '">'; 
                            	$l10n->_e('3rdLevelAnswer'); 
                              	echo '</label>' .
                            	'<input type="radio" id="radio4ForQuestion' . $a['question_id'] . '" name="answerForQuestion' . $a['question_id'] . '" value="4"><label for="radio4ForQuestion' . $a['question_id'] . '">'; 
                            	$l10n->_e('4thLevelAnswer'); 
                              	echo '</label>' .
                            	'<input type="radio" id="radio5ForQuestion' . $a['question_id'] . '" name="answerForQuestion' . $a['question_id'] . '" value="5"><label for="radio5ForQuestion' . $a['question_id'] . '">'; 
                            	$l10n->_e('5thLevelAnswer'); 
                              	echo '</label>' .
                    		'</span>' .
                    		'<span>' .
                    			'<input type="text" id="commentForQuestion' . $a['question_id'] . '" name="commentForQuestion' . $a['question_id'] . '" style="width:40%" class="styled-input" placeholder="Your Comment...">' . 
                    		'</span>' .
                		'</div>';
            	}
        	}?>
        	
        	<?php 
            	foreach ($particular as $b) {
            		echo '<div class="row">' . 
              				'<label name="question[' . $b['question_id'] . ']" visibility="hidden">' . $b['question_id'] . '</label>' .
                  			'<span class="left-question">' . $b['question_content_en'] .  '</span>' .
                    		'<span class="buttonset">' .
                        		'<input type="radio" id="radio1ForQuestion' . $b['question_id'] . '" name="answerForQuestion' . $b['question_id'] . '" value="1"><label for="radio1ForQuestion' . $b['question_id'] . '">';
                        		$l10n->_e('1stLevelAnswer');
                          		echo '</label>' .
                        		'<input type="radio" id="radio2ForQuestion' . $b['question_id'] . '" name="answerForQuestion' . $b['question_id'] . '" value="2"><label for="radio2ForQuestion' . $b['question_id'] . '">';
                        		$l10n->_e('2ndLevelAnswer');
                          		echo '</label>' .
                        		'<input type="radio" id="radio3ForQuestion' . $b['question_id'] . '" name="answerForQuestion' . $b['question_id'] . '" value="3"><label for="radio3ForQuestion' . $b['question_id'] . '">';
                        		$l10n->_e('3rdLevelAnswer');
                          		echo '</label>' .
                        		'<input type="radio" id="radio4ForQuestion' . $b['question_id'] . '" name="answerForQuestion' . $b['question_id'] . '" value="4"><label for="radio4ForQuestion' . $b['question_id'] . '">';
                        		$l10n->_e('4thLevelAnswer');
                          		echo '</label>' .
                        		'<input type="radio" id="radio5ForQuestion' . $b['question_id'] . '" name="answerForQuestion' . $b['question_id'] . '" value="5"><label for="radio5ForQuestion' . $b['question_id'] . '">';
                        		$l10n->_e('5thLevelAnswer');
                          		echo '</label>' .
                    		'</span>' .
                    		'<span>' .
                    			'<input type="text" id="commentForQuestion' . $b['question_id'] . '" name="commentForQuestion' . $b['question_id'] . '" style="width:40%" class="styled-input" placeholder="Your Comment...">' .
                    		'</span>' .
                		'</div>';
            	}                
        	?>
        	              
    		<button type="submit" class="btn-check btn-maroon btn-icon" name="addAnswers" id="addAnswers" style="margin-top: 2em;"><?php $l10n->_e('submitBtn'); ?><span></span></button>
			<div id="submit-loader">
                <img src="../includes/img/search-loader-light.gif" alt="Submitting…">
            </div>
		</section>
	</form>
</div>

<!--END MAIN BODY CONTENT -->

<script>
    'use strict';
    var requiredRadioButtonMessage = "<?php $l10n->_e('requiredRadioButton', AntiXSS::JS_STRING); ?>";
    var l10n = {
        submitErrorMsg: '<?php $l10n->_e('submitErrorMsg', AntiXSS::JS_STRING); ?>'
    };
</script>
<script src='includes/js/questionnaire.js' charset='utf-8'></script>