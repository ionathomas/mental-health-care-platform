const startButton = document.getElementById("start-button");
const questionsContainer = document.getElementById("questions-container");
const coverContainer = document.getElementById("startpage");

//reveal cover
startButton.addEventListener("click", () => {
  questionsContainer.hidden = false;
  coverContainer.hidden = true;
});

const answers = [
  "Not At all",
  "Several Days",
  "More Than Half the Days",
  "Nearly Every Day"];
const quiz = [
  {
    id: 1,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: <strong>Little interest or pleasure in doing things</strong>?"
  },
  {
    id: 2,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: Feeling down, depressed or hopless?"
  },
  {
    id: 3,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: Trouble falling asleep, staying asleep, or sleeping too much<?"
  },
  {
    id: 4,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: Feeling tired or having little energy?"
  },
  {
    id: 5,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: Poor appetite or overeating?"
  },
  {
    id: 6,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: <strong>Feeling bad about yourself - or that you're a failure or have let yourself or your family down</strong>?"
  },
  {
    id: 7,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: <strong>Trouble concentrating on things, such as reading the newspaper or watching television</strong>?"
  },
  {
    id: 8,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: Moving or speaking so slowly that other people could have noticed. Or, the opposite - being so fidgety or restless that you have been moving around a lot more than usual?"
  },
  {
    id: 9,
    question: "Over the past 2 weeks, how often have you been bothered by any of the following problems: Thoughts that you would be better off dead or of hurting yourself in some way?"
  }
];

const quizApp = function () {
  const totalque = quiz.length;
  this.currentQuestion = 0;

  this.displayQuiz = function (cque) {
    selectedopt = quiz[this.currentQuestion].score;
    this.currentQuestion = cque;
    //show a question
    if (this.currentQuestion < totalque) {
      $("#tque").html(totalque);
      $("#previous").attr("disabled", false);
      $("#next").attr("hidden", false);
      $("#next").attr("disabled", false);
      $("#submit").attr("hidden", true);
      $("#qid").html(quiz[this.currentQuestion].id + ".");

      $("#question").html(quiz[this.currentQuestion].question);
      $("#question-options").html("");
      for (const [answerNo, answer] of answers.entries()) {
        $("#question-options").append(
          "<div class='form-check option-block'>" +
          "<label class='form-check-label'>" +
          "<input type='radio' class='form-check-input' name='option' " +
          (answerNo == selectedopt ? "checked" : "") +
          " id='q" +
          answerNo +
          "' value='" +
          answerNo +
          "'><span id='optionval'>" +
          answer +
          "</span></label>"
        );
      }
    }
    //prevent going back on first question
    if (this.currentQuestion <= 0) {
      $("#previous").attr("disabled", true);
    }
    //last question
    if (this.currentQuestion == totalque - 1) {
      $("#next").attr("hidden", true);
      $("#submit").attr("hidden", false);
    }
  };

  //remember answer
  this.checkAnswer = function (option) {
    quiz[this.currentQuestion].score = option;
    quiz[this.currentQuestion].answer = answers[option];
  };

  //change current question shown
  this.changeQuestion = function (delta) {
    this.currentQuestion = this.currentQuestion + delta;
    this.displayQuiz(this.currentQuestion);
  };
};

const jsq = new quizApp();

let selectedopt;
//initialize
$(document).ready(function () {
  jsq.displayQuiz(0);

  $("#question-options").on(
    "change",
    "input[type=radio][name=option]",
    function (e) {
      //var radio = $(this).find('input:radio');
      $(this).prop("checked", true);
      selectedopt = $(this).val();
    }
  );
});

$("#next").click(function (e) {
  e.preventDefault();
  if (selectedopt) {
    jsq.checkAnswer(selectedopt);
    jsq.changeQuestion(1);
  }
});

$("#previous").click(function (e) {
  e.preventDefault();
  if (selectedopt) {
    jsq.checkAnswer(selectedopt);
  }
  jsq.changeQuestion(-1);
});

$("#submit"). click(function (e) {
  if (selectedopt) {
    jsq.checkAnswer(selectedopt);

    //sneak in a form to submit data to backend.
    const newForm = document.createElement("form");
    newForm.setAttribute('action', 'self-assessment-test.php');
    newForm.setAttribute('method', 'POST');
    //newForm.method("post");
    //newForm.action("index.php");
    let totalSum = 0;
    newForm.id = "questions";
    //each question
    for (const [questionNo, questionData] of quiz.entries()) {
      const res = questionData.score;
      totalSum += Number(res);
      const newHiddenInput = document.createElement("input");
      newHiddenInput.type = "hidden";
      newHiddenInput.value = res;
      newHiddenInput.name = "question-" + questionNo;
      newForm.appendChild(newHiddenInput);
    }
    //total
    const newHiddenInput = document.createElement("input");
    newHiddenInput.type = "hidden";
    newHiddenInput.value = totalSum;
    newHiddenInput.name = "total";
    newForm.appendChild(newHiddenInput);

    $(document.body).append(newForm);
 
  }
});





