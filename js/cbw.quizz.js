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
    $('#start_quizz, #quizz_wiso').click(function () {
        getNextQuestion();
    });

    // Admin Quizz
    $('#nav_admin_question').click(function () {
       $.get("api.php", {action: "adminquizz"})
           .done(function (data) {
               $('#content').replaceWith(data);
               $('#stats').addClass("d-none");
               $('#add_question').click(function () {
                   $.get("api.php", {action: "addquestionform"})
                       .done(function (data) {
                           $('#content').replaceWith(data);
                           questionNumChanged();
                           $('#num_answer').change(function () {
                                questionNumChanged();
                           });
                           $('#cancel_form').click(function () {
                               $('#nav_admin_question').trigger("click");
                           });
                           $('#submit_form').click(function () {
                               saveQuestion();
                               $('#nav_admin_question').trigger("click");
                           });
                       });
               });
               $('#del_question').click(function () {
                   $.get("api.php", {action: "showdeletedquestion"})
                       .done(function (data) {
                           $('#content').replaceWith(data);
                       });
               });
           });
    });

});

function getNextQuestion(){
    $.get("api.php", {action: "nextquestion"})
        .done(function (data) {
            $('#content').replaceWith(data);
            $('#next_question').click(function () {
                getNextQuestion();
            });
            $('#stats').removeClass("d-none");
            //TODO: get stats

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
function questionNumChanged(){
    var template = $('.answer_template')[0].outerHTML;
    template = template.replace("d-none", "");
    template = template.replace("answer_template", "");

    var current_answer_count = $('.answer_row').length-1;
    var changed_answer_count = $('#num_answer').val();
    if(current_answer_count == 0){
        for(var i = 0; i<changed_answer_count; i++){
            var tmp = template;
            tmp = tmp.replaceAll("{num}", i);
            tmp = tmp.replaceAll("{num_add_one}", i+1);
            $('#question_form .answers').append(tmp);
            delete tmp;
        }
    } else {
        if (current_answer_count > changed_answer_count) {
            while($('.answer_row').length-1 > changed_answer_count){
                $('#question_form .answers .answer_row:last-of-type').remove();
            }
        } else {
            for(var i = current_answer_count-1; i<changed_answer_count-1; i++) {
                var tmp = template;
                tmp = tmp.replaceAll("{num}", i+1);
                tmp = tmp.replaceAll("{num_add_one}", i+2);
                $('#question_form .answers').append(tmp);
                delete tmp;
            }
        }
    }
}
function saveQuestion(){
    if($('#question_text').val().trim() === ""){
        $('#question_text').addClass("has_error");
        $('#question_text').focus();
        return false;
    }
    // type multiselect - requires at least 2 answers to be correct
    if($('#type option:selected').val() == "1" && $('#question_form .answers input[type=checkbox]:checked').length < 2){
        $('#question_form .answers input[type="checkbox"]').parent().addClass("has_error");
        $('.alert_box:first-of-type').fadeOut(1000);
        $('<div class="alert alert-danger alert_box" role="alert"><strong>Fehler!</strong> Mehrfachauswahl mit weniger als 2 richtigen Anworten sind nicht möglich (Dafür ist Einzelauswahl).</div>').insertBefore('#main_content');
        return false;
    }
    // type singleselect - requires one to be correct, error if multiple ore none are selected
    if($('#type option:selected').val() == "2" && ($('#question_form .answers input[type=checkbox]:checked').length >= 2 || $('#question_form .answers input[type=checkbox]:checked').length < 1)){
        $('#question_form .answers input[type="checkbox"]').parent().addClass("has_error");
        $('.alert_box:first-of-type').fadeOut(1000);
        $('<div class="alert alert-danger alert_box" role="alert"><strong>Fehler!</strong> Einzelauswahl mit mehr oder weniger als einer richtigen Anworten sind nicht möglich (Für mehrere Möglichkeiten ist Mehrfachauswahl da).</div>').insertBefore('#main_content');
        return false;
    }

    $('.alert_box:first-of-type').fadeOut(1000);

    var url = "api.php?action=addquestion";
    var param_post = "";
    $('#question_form input').each(function () {
        if($(this).attr("type") == "checkbox"){
            param_post += $(this).attr("id") + "||" + (($(this).is(":checked")) ? 1 : 0) + "\n";
        } else {
            param_post += $(this).attr("id") + "||" + $(this).val() + "\n";
        }
    });
    $('#question_form select').each(function () {
            param_post += $(this).attr("id") + "||" + $(this).val() + "\n";
    });
    $.post(url, { input_data: param_post }, function (data) {

    })
}


/* replaceAll for Strings */
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};