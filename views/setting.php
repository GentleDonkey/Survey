<style>
    @import url('includes/css/setting.css');
</style>

<div id="content" class="xfluid">

    	<section id='setting'> 
            <header>
                <h1 class='page-heading'><span data-ventus-icon='&#xA1;' aria-hidden="true"></span><?php $l10n->_e('pageTitle'); ?></h1>
            </header>
            
            <select id="dropdownlist" name="dropdownlist">
            	<option class="option" value="0")>Genneral</option>
            	<?php foreach($Services as $serv){
            		echo '<option class="option" value="'.$serv['service_id'].'">'. $serv['service_name_en'] .'</option>';
            	}?>
            </select>
            <h2 style="margin-top: 10px;"><?php $l10n->_e('prioritiesSectionTitle'); ?></h2>
            <?php
            	$i = 1;
                echo '<ul class="sortable" id="active">';
                if(!empty($Questions)){
                	foreach($Questions as $ques){
                		echo '<li id="'.$ques['question_id'].'"><span>' . $i . '</span> <span class="priority">' . $ques['question_content_en'] . '</span></li>';
                		$i++;
                	}
                }
                echo '</ul>';
             ?>
             <h2 style="margin-top: 10px;"><?php $l10n->_e('deleteSectionTitle'); ?></h2>
             <?php   
                $j = 1;
                echo '<ul class="sortable" id="deleted">';
                if(!empty($DelQuestions)){
                	foreach($DelQuestions as $delques){
                		echo '<li id="'.$delques['question_id'].'"><span>' . $j . '</span> <span class="priority">' . $delques['question_content_en'] . '</span></li>';
                		$j++;
                	}
                }
                echo '</ul>';
            ?>
		</section>

</div>

<script>

    $(document).ready(function() {

        $(".sortable").sortable({
        	connectWith : ".sortable",
        	update: function(event, ui) {
        		var postactivedata = $("#active").sortable('toArray');
                for (var i = 0; i < postactivedata.length; i++) {
                	var x = document.getElementById(postactivedata[i]);
                	var spans = x.getElementsByTagName('span');
                	spans[0].innerHTML = i+1;
				}
				var postdeleteddata = $("#deleted").sortable('toArray');
				for (var i = 0; i < postdeleteddata.length; i++) {
                	var x = document.getElementById(postdeleteddata[i]);
                	var spans = x.getElementsByTagName('span');
                	spans[0].innerHTML = i+1;
				}
                console.log("after");
                console.log(postactivedata);
				console.log(postdeleteddata);
                $.ajax({
                	url: 'setting.php?page=update',
                	type: 'POST',
                	data: {'order':postactivedata, 'delete':postdeleteddata},
                	success: function (data) {
                		console.log("after ajax");
                    	console.log(data);
                         //window.location.href = 'setting.php';
                     }
                });
        	}
        });

        $("#dropdownlist").change(function(){
            var id = $(this).val();
            console.log(id);
        	window.location.href = 'setting.php?service='+id;
        });

        $("#dropdownlist").ready(function() {
        	var param = getQueryVariable("service");
        	document.getElementById("dropdownlist").selectedIndex = parseInt(param);
        });

        function getQueryVariable(variable) {
          var query = window.location.search.substring(1);
          var vars = query.split("&");
          for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) {
              return pair[1];
            }
          } 
          return '0';
        }
		
    });

</script>
























