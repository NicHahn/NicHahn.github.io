document.addEventListener("DOMContentLoaded", () => {
  var input = "";
  var savedinput;
  let operator = "";
  var result = undefined;

  document.querySelectorAll("button").forEach(function (button) {
    button.onclick = function () {
      if (button.dataset.value !== undefined) {
        input += button.dataset.value;
        document.querySelector("#viewresult").innerHTML = input;
        savedinput = input;
      }
      // check if clicked button is an operator
      if (button.dataset.operand !== undefined) {
        savedinput = input;
        calculate();
        operator = button.dataset.operand;
        input = "";
        document.querySelector("#viewresult").innerHTML = input;
      }
    };
  });

  document.querySelector("#result").onclick = () => {
    calculate();
    input = "";
    document.querySelector("#viewresult").innerHTML = result;
  };

  document.querySelector("#reset").onclick = () => {
    input = "";
    savedinput = "";
    result = undefined;
    document.querySelector("#viewresult").innerHTML = "";
  };

  function calculate() {
    //  check if savedinput is not a number
    let parsed = parseFloat(savedinput);
    if (isNaN(parsed)) {
      return false;
    }
    if (result === undefined) {
      result = parsed;
    } else {
      if (operator === "+") {
        result = result + parsed;
      }
      if (operator === "-") {
        result = result - parsed;
      }
      if (operator === "*") {
        result = result * parsed;
      }
      if (operator === "/") {
        result = result / parsed;
      }
    }
  }
});
