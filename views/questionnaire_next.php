<style scoped>@import url('includes/css/questionnaire.css');</style>

<!--BEGIN MAIN BODY CONTENT-->

<h1><?php $l10n->_e('title'); ?></h1>

<div id="normal-content">
		<section id='questionnaire'> 
			<h2 class="styled-h2" style="text-align: center; margin-bottom: 10em;">
				<span style="color: black"><?php echo $student['0']['student_first_name'] . ' ' . $student['0']['student_last_name']; ?></span>
				<?php $l10n->_e('thankYou1'); ?>
				<span style="color: black"><?php echo $student['0']['service_name_en']; ?></span>
				<?php $l10n->_e('thankYou2'); ?>
				<br>
				<?php 
				if($model -> checkOtherSurvey($_GET['user'])){
					echo '<br>'; $l10n->_e('otherSurveyAsked1'); 
					echo '<span style="color: black">'; echo $newQues['0']['service_name_en']; echo'</span>';
					$l10n->_e('otherSurveyAsked2');
					echo '<span style="color: black">'; echo $newQues['0']['service_name_en']; echo'</span>';
					$l10n->_e('otherSurveyAsked3');
					echo '<span style="color: black">'; echo $newQues['0']['service_name_en']; echo'</span>';
					$l10n->_e('otherSurveyAsked4');
					echo '</h2>';
					echo '<div style="text-align:center"><a padding-right="1000px" href="questionnaire.php?user=' . $newQues['0']['email_link'] .'" class="btn-check btn-maroon btn-icon">'; $l10n->_e('sureBtn'); echo '<span></span></a>';
					echo '<span style="padding-right: 10%"></span>';
					echo '<a href="javascript:closeMe()" class="btn-icon btn-maroon btn-cross">'; $l10n->_e('sorryBtn'); echo '<span></span></a></div>';
				}else{
					echo '</h2>';
					echo '<div style="text-align:center"><a href="javascript:closeMe()" class="btn-icon btn-maroon btn-heart">'; $l10n->_e('doneBtn'); echo '<span></span></a></div>';
				}?>
		</section>
</div>
<!--END MAIN BODY CONTENT -->

<script>
function closeMe()
{
	window.open('','_self').close();
}
</script>
