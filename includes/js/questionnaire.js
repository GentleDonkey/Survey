'use strict';

//Initialiaze button set for radio buttons
$('.buttonset').buttonset();
//$('#consent_to_emails').button();

$('#normal-content > form .buttonset input[type="radio"]').change(function(){
    if(this.checked || $(this).siblings('input[type="radio"]:checked').length > 0) {
        $(this).parent().prev().children('.error').remove();
    }
});

$('form').submit(function(e){
    var valid = true, $this = $(this);
    var errorCallback = function() {
        $('#submit-loader').hide();
        $('form button[type="submit"]').show();
        alert(l10n.submitErrorMsg);
    };

    e.preventDefault();
    
    $('.error').remove();
    
    $('#normal-content > form .buttonset').each(function(){
        if($('input[type="radio"]:checked', this).length === 0) {
            $(this).prev().append('<br><span class="error">'+requiredRadioButtonMessage+'</span>');
            valid = false;
        }
    });
    
    if(!valid) {
        return;
    }
    
    $('form button[type="submit"]').hide();
    $('#submit-loader').show();
    
    /*$.ajax({
        type: 'GET',
        url: 'questionnaire.php',
        data: {
            page: 'check-student-num',
            student_num: $('#student_num').val(),
            date_of_birth: $('#date_of_birth').val()
        },
        dataType: 'text',
        timeout: 20000
    }).done(function(data){
        if(data === '0') {
            alert(studentNumDobMismatch);
            $('#submit-loader').hide();
            $('form button[type="submit"]').show();
            return;
        }*/
        
        $.ajax({
            type: $this.prop('method'),
            url: $this.prop('action'),
            data: $this.serialize(),
            //timeout: 20000
        }).done(function(data){
        	console.log(data);
            window.location.href = 'questionnaire.php?page=complete&user='+data;
        }).fail(errorCallback);

    //}).fail(errorCallback);
});