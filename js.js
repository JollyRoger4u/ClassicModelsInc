function subtract(incNoOfItems){
  noOfItems = parseInt(incNoOfItems)-1;
  document.getElementById("noOfItems").innerHTML = noOfItems;
  document.getElementById("noOfItems").setAttribute("value", noOfItems);
  var subValue = "subtract(" + noOfItems + ")";
  document.getElementById("subtract").setAttribute("onclick", subValue);
  var addValue = "add(" + noOfItems + ")";
  document.getElementById("add").setAttribute("onclick", addValue);
}

function add(incNoOfItems){
  noOfItems = parseInt(incNoOfItems) + 1;
  document.getElementById("noOfItems").innerHTML = noOfItems;
  document.getElementById("noOfItems").setAttribute("value", noOfItems);
  var subValue = "subtract(" + noOfItems + ")";
  document.getElementById("subtract").setAttribute("onclick", subValue);
  var addValue = "add(" + noOfItems + ")";
  document.getElementById("add").setAttribute("onclick", addValue);
}

