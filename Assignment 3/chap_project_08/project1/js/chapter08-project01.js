/* add loop and other code here ... in this simple exercise we are not
   going to concern ourselves with minimizing globals, etc */


for (var i = 0; i < 3; i++) {
  output(filenames, titles, quantities, prices, calculateTotal());
}

var printSubTotal = subTotal(quantities,prices);
var printTax = tax(printSubTotal);
var printShipping = shipping(printSubTotal);
var printGrandTotal = grandTotal(printSubTotal, printTax, printShipping);
