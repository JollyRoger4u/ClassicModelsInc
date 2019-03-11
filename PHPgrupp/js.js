var counter = 0;

function subtract(){
  counter = counter-1;
  document.getElementById("counter").innerHTML = counter;
}

function add(){
  counter = counter + 1;
  document.getElementById("counter").innerHTML = counter;
}

function reset(){
  counter = 0;
  document.getElementById("counter").innerHTML = counter;
}