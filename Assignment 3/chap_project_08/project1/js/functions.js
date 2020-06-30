/* define functions here */

var calculateTotal = function(quantity, price) {
  return quantity * price;
};

var output = function outputCartRow(file, title, quantity, price, total) {
  total = calculateTotal(quantity[i], price[i]);
  document.write("<tr>");
  document.write("<td><img src='images/" + file[i] + "'</td>");
  document.write("<td>" + title[i] + "</td>");
  document.write("<td>" + quantity[i] + "</td>");
  document.write("<td>" + price[i].toFixed(2) + "</td>");
  document.write("<td>" + total.toFixed(2) + "</td>");
  document.write("</tr>");
};

var subTotal = function outputSubtotal(quantity, price) {
  var subtotals = 0;
  for (var i = 0; i < price.length; i++) {
    var totals = quantity[i] * price[i];
    subtotals += totals;
  }
  return subtotals;
};

var tax = function calculateTax(subTotal){
    return subTotal * 0.1;

};


var shipping = function calculateShipping(subTotal){
  if (subTotal < 1000){
    return 40;
  } else {
    return 0;
  }
};

var grandTotal = function calculateGrandTotal(subTotal, tax, shipping){
  return subTotal + tax + shipping;
};
