// $(window).on('load', function () {
//     $('#instructionModal').modal({ backdrop: 'static', keyboard: false })
//     $('#instructionModal').modal('show');
// });


jQuery(document).ready(function ($) {

    if (window.history && window.history.pushState) {

        window.history.pushState('forward', null, './#forward');

        $(window).on('popstate', function () {
            alert('You cannot go backward. Your data will not be saved');
        });

    }
});

$(document).ready(function () {
    $("#addButton").click(function () {
        if (($('.form-horizontal .control-group').length + 1) > 10) {
            alert("Only 2 control-group allowed");
            return false;
        }
        var id = ($('.form-horizontal .control-group').length + 1).toString();
        $('.form-horizontal').append('<div style="margin-top:1rem;" class="control-group" id="control-group' + id + '"><div class="controls' + id + '"><input type="text" class="form-control myinputs" id="imagination" placeholder="Type your imaginations here"></div></div>');
    });

    $("#removeButton").click(function () {
        if ($('.form-horizontal .control-group').length == 1) {
            alert("No more textbox to remove");
            return false;
        }

        $(".form-horizontal .control-group:last").remove();
    });

    
});


$('#startBtn').on('click', function (e) {
    $('#startBtn').attr('disabled', true);
    var section1 = document.getElementById('one');
    $('#two').show('slow');
    var display1 = document.querySelector('#time1'), timer = new CountDownTimer(180);

    timer.onTick(timeFormat).start();
    function timeFormat(minutes, seconds) {

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display1.textContent = minutes + ':' + seconds;
        if (minutes == 00 && seconds == 00) {
            $('#submissionModal').modal({ backdrop: 'static', keyboard: false });
            $('#submissionModal').modal('show');
        }
    }
});



// https://stackoverflow.com/questions/48717767/combine-array-from-html-to-jquery
function saveData(e) {
    var userName = document.getElementById('userName').value;
    var otp = [];

    $(".myinputs").each(function () {
        if ($(this).val()) {
            otp.push($(this).val());
        }
    });
    var ilength = otp.length;
    var imagineData = otp.join(",");
    var imgName = document.getElementById("objImg").getAttribute("alt");
    e.preventDefault();
    $.ajax
        ({
            type: "POST",
            url: "/reImagine/submit",
            data: {
                name: userName,
                imgObj: imgName,
                ilength: ilength,
                imaginations: imagineData
            }
        }).done(function (data) {
            $('#confirmationModal').modal({ backdrop: 'static', keyboard: false })
            $('#confirmationModal').modal('show');
            setTimeout(function () {
                $('#confirmationModal').modal('hide');
            }, 3000);
            $(".myinputs").attr('disabled', true)
            $("#riSubmit").attr('disabled', true)
        })
}

$("#riSubmit").click(function (e) {
    $('#timer').css("display","none");
    $('#submissionModal').modal({ backdrop: 'static', keyboard: false })
    $('#submissionModal').modal('show');
    $('#finalSubmit').attr('disabled', true);
    $('#userName').keyup(function () {
        if ($(this).val().length != 0)
            $('#finalSubmit').attr('disabled', false);
        else
            $('#finalSubmit').attr('disabled', true);
    })
});

$("#finalSubmit").click(function (e) {
    $('#submissionModal').modal('hide');
    saveData(e);
});


