$(document).ready(function () {
    $('#toggle_log').click(function () {
      if($('pre#log').hasClass('d-none')){
          $('pre#log').removeClass('d-none');
      } else {
          $('pre#log').addClass('d-none');
      }
    });

    // Save username
    $('#save_user_name').click(function () {
        var savename =  $('#save_name').is(':checked') ? "1" : "0";
        $.get("api.php", {action: "savename", username:$('#username').val(), save_name: savename})
           .done(function (data) {
               if(data === "OK"){
                   $('#ask_user_name').fadeOut(500);
               }
           });
    });

    // Save no username
    $('#save_noname').click(function () {
        $.get("api.php", {action: "noname"})
            .done(function (data) {
                console.log(data);
                if(data === "OK"){
                    $('#ask_user_name').fadeOut(500);
                }
            });
    });

    // Next question
    $('#start_quizz').click(function () {
        getNextQuestion();
    });

});

function getNextQuestion(){
    $.get("api.php", {action: "nextquestion"})
        .done(function (data) {
            $('#content').replaceWith(data);
            $('#next_question').click(function () {
                getNextQuestion();
            });

            //Check answer
            $('#check_question').click(function () {
                $(this).addClass("disabled");
                var checked = [];
               $('#quizz_answers input:checked').each(function(){
                   checked.push($(this).val());
               });
               var answer = checked.join(':');
                $.get("api.php", {action: "checkquizz", qid: $('#question_id').val(), area: $('#area').val(), qtype: $('#qtype').val(), answers: answer})
                    .done(function (data) {
                        console.log(data);
                        if(data.match("^ERROR")){
                            $('<div class="alert alert-danger" role="alert"><strong>ERROR!</strong> Something broke, tell Maik \"'+ data +'\" happend.</div>').insertBefore('#main_content');
                            console.log(data);
                            return;
                        }
                        $('#quizz_answers i').remove();
                        if(data === "OK"){
                            $('#quizz_answers input:checked').each(function(){
                                $(this).next().append('<i class="fas fa-check-circle answer_right"></i>')
                            });
                        } else {
                            var correct = [];
                            if(data.match(":")){
                                correct = data.split(':');
                            } else {
                                correct.push(data);
                            }
                            $('#quizz_answers input').each(function(){

                                if(correct.indexOf($(this).val()) > -1){
                                    $(this).next().append('<i class="fas fa-check-circle answer_right"></i>');
                                } else {
                                    $(this).next().append('<i class="fas fa-times-circle answer_wrong"></i>');
                                }
                            });


                        }
                    });

            });
        });
}