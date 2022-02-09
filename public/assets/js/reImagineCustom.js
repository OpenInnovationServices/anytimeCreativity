jQuery(document).ready(function($) {

    if (window.history && window.history.pushState) {

        window.history.pushState('forward', null, './#forward');

        $(window).on('popstate', function() {
            alert('You cannot go backward. Your data will not be saved');
        });

    }
});

$(document).ready(function() {
    $("#addButton").click(function() {
        if (($('.form-horizontal .control-group').length + 1) > 10) {
            alert("Only 2 control-group allowed");
            return false;
        }
        var id = ($('.form-horizontal .control-group').length + 1).toString();
        $('.form-horizontal').append('<div style="margin-top:1rem;" class="control-group" id="control-group' + id + '"><div class="controls' + id + '"><input type="text" class="form-control myinputs" id="imagination" placeholder="Type your imaginations here"></div></div>');
    });

    $("#removeButton").click(function() {
        if ($('.form-horizontal .control-group').length == 1) {
            alert("No more textbox to remove");
            return false;
        }

        $(".form-horizontal .control-group:last").remove();
    });

    $('#two').show('slow');
    $('#timer').show('slow');
    var display1 = document.querySelector('.time1'),
        timer = new CountDownTimer(300);
    // getRandomImgName();
    timer.onTick(timeFormat).start();

    function timeFormat(minutes, seconds) {

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display1.textContent = minutes + ':' + seconds;
        if (minutes == 00 && seconds == 00) {
            $('#timer').css("display", "none");
            $('#submissionModal').modal({ backdrop: 'static', keyboard: false })
            $('#submissionModal').modal('show');
            $('#finalSubmit').attr('disabled', true);
            $('#userName').keyup(function() {
                if ($(this).val().length != 0)
                    $('#finalSubmit').attr('disabled', false);
                else
                    $('#finalSubmit').attr('disabled', true);
            })
            var display2 = document.querySelector('#time2'),
                timer2 = new CountDownTimer(60);

            timer2.onTick(timeFormat2).start();

            function timeFormat2(minutes, seconds) {

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display2.textContent = minutes + ':' + seconds;
                if (minutes == 00 && seconds == 00) {
                    saveData()
                }
            }
        }
    }

});

// https://stackoverflow.com/questions/48717767/combine-array-from-html-to-jquery
function saveData(e) {
    var userName = document.getElementById('userName').value;
    var bestIdea = document.getElementById("bestIdea").value;

    if (isEmpty(userName)) {
        $('#submissionModal').modal('hide');
        $('#failedModal').modal({ backdrop: 'static', keyboard: false });
        $('#failedModal').modal('show');
        return false;
    }

    if (isEmpty(bestIdea)) {
        $('#submissionModal').modal('hide');
        $('#failedModal').modal({ backdrop: 'static', keyboard: false });
        $('#failedModal').modal('show');
        return false;
    }

    var imgName = 'esb-poolbeg-chimneys';
    // e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/Reimagine/submit",
        data: {
            name: userName,
            imgObj: imgName,
            bestIdea: bestIdea
        }
    }).done(function(data) {
        $('#submissionModal').modal('hide');
        // $('#confirmationModal').modal({ backdrop: 'static', keyboard: false })
        // $('#confirmationModal').modal('show');
        // setTimeout(function () {
        //     $('#confirmationModal').modal('hide');
        // }, 3000);
        $('#successMessage').show();
        $(".myinputs").attr('disabled', true)
        $("#riSubmit").attr('disabled', true)
            // window.location.replace("http://www.fergalbrophy.com/eCHALLENGES");
    }).fail(function(data) {
        $('#failedMessage').show();
        console.log('An error occurred.');
        console.log(data);
    })
}

// Empty check
function isEmpty(val) {
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

$("#finalSubmit").click(function() {
    $('#submissionModal').modal('hide');
    saveData();
});

function getRandomImgName() {
    var images = ['eir-poles', 'used-tyres', 'unused-office-space', 'esb-poolbeg-chimneys', 'broken-pallets'];
    var randomNumber = Math.floor(Math.random() * images.length);
    var img = document.getElementById("objImgCustom")
    var objname = document.getElementById("objName")
    img.setAttribute("src", "/assets/images/ReImagineApp/poolbegChimney.png")
    img.setAttribute("alt", "ESB Poolbeg Chimneys")
    objname.innerHTML = "ESB Poolbeg Chimneys";
}