'use strict';

$('form').submit(function(e){
    //var valid = true, 
    $this = $(this);
    var errorCallback = function() {
        $('#submit-loader').hide();
        $('form button[type="submit"]').show();
        alert(l10n.submitErrorMsg);
    };

    e.preventDefault();
    
    $('.error').remove();
    
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
            window.location.href = 'questionnaire.php';
        }).fail(errorCallback);

    //}).fail(errorCallback);
});



























