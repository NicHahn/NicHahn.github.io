document.addEventListener("DOMContentLoaded", () => {
  var input = "";
  var savedfirstoperand;
  let operand = "";

  document.querySelectorAll("button").forEach(function (button) {
    button.onclick = function () {
        if (button.dataset.value !== undefined) {
            console.log(typeof button.dataset.value);
            input += button.dataset.value;
            console.log(input);
            document.querySelector("#viewresult").innerHTML = input;
        }

      if (button.dataset.operand !== undefined) {
        savedfirstoperand = input;
        input = '';
        document.querySelector("#viewresult").innerHTML = input;
        operand = button.dataset.operand;
    }

    };
  });


  document.querySelector("#result").onclick = () => {
    if (operand === "+") {
      document.querySelector("#viewresult").innerHTML =
        parseFloat(input) + parseFloat(savedfirstoperand);
    }
    if (operand === "-") {
      document.querySelector("#viewresult").innerHTML =
        parseFloat(input) - parseFloat(savedfirstoperand);
    }
    if (operand === "*") {
      document.querySelector("#viewresult").innerHTML =
        parseFloat(input) * parseFloat(savedfirstoperand);
    }
    if (operand === "/") {
      document.querySelector("#viewresult").innerHTML =
        parseFloat(input) / parseFloat(savedfirstoperand);
    }
    input = '';
  };

  document.querySelector('#reset').onclick = () => {
      input = '';
      savedfirstoperand = '';
      document.querySelector("#viewresult").innerHTML = '';
  }
});
