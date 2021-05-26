document.addEventListener("DOMContentLoaded", () => {
  var input = "";
  var savedinput;
  let operator = "";
  var result = undefined;
  let operator_is_first_clicked = false;

  document.querySelectorAll("button").forEach(function (button) {
    button.onclick = function () {
      if (button.dataset.value !== undefined) {
        input += button.dataset.value;
        document.querySelector("#viewresult").innerHTML = input;
        savedinput = input;
      }
      // check if clicked button is an operator
      if (button.dataset.operand !== undefined) {
        document.querySelector("#viewinput").innerHTML += input;
        if(!operator_is_first_clicked){
          operator_is_first_clicked = true;
          document.querySelector('#viewinput').style.visibility = 'visible';
        }
        savedinput = input;
        calculate();
        operator = button.dataset.operand;
        input = "";
        document.querySelector("#viewresult").innerHTML = input;
        document.querySelector("#viewinput").innerHTML += operator;
      }
    };
  });
  
  document.querySelector("#result").onclick = () => {
    document.querySelector("#viewinput").innerHTML += input;
    calculate();
    input = "";
    document.querySelector("#viewresult").innerHTML = result;
  };

  document.querySelector("#reset").onclick = () => {
    input = "";
    savedinput = "";
    result = undefined;
    document.querySelector("#viewresult").innerHTML = "";
    document.querySelector("#viewinput").innerHTML = "";
    document.querySelector('#viewinput').style.visibility = 'hidden';
    operator_is_first_clicked = false;
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
