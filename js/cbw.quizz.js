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
        });
}