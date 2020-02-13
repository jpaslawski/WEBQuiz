window.onload = function () {
    element = document.getElementById("countDown");
    if (element) {
        sec = parseInt(window.localStorage.getItem("seconds"));
        min = parseInt(window.localStorage.getItem("minutes"));

        //Get question number
        question = document.getElementById("qNumber");

        if ((parseInt(min * 60 + sec)) && (question.textContent == window.localStorage.getItem("qNumber"))) {
            var oneMinute = (parseInt(min * 60) + sec);
        } else {
            var oneMinute = 90;
            window.localStorage.setItem("qNumber", question.textContent);
        }
        display = document.querySelector('#countDown');
        startTimer(oneMinute, display);
    }
};

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + " " + " " + seconds;

        if (--timer < 0) {
            nextQuestion();
        }

        window.localStorage.setItem("seconds", seconds);
        window.localStorage.setItem("minutes", minutes);
    }, 1000);
}


function selectOnlyThis(id) {
    for (var i = 1; i <= 4; i++)
    {
        document.getElementById("check" + i).checked = false;
    }
    document.getElementById(id).checked = true;
}

function nextQuestion() {
    var checkedValue = "-";

    for (var i = 1; i <= 4; i++)
    {
        if (document.getElementById("check" + i).checked === true) {
            checkedValue = document.getElementById("check" + i).name;
            break;
        }
    }

    window.location.href = 'http://localhost/WEBQuiz/include/question_processing.php?answer=' + checkedValue;
}