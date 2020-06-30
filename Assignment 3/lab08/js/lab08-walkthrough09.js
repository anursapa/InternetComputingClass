/* code goes here */
var isCanadian = true;

function calculateTax(amount, tax) {
  return amount * tax();

  var tax = function() {
    if (isCanadian) {
      return 0.05;
    } else {
      return 0.0;
    }
    return amount * tax();
  }
}

  function calculateTotal(price, quantity) {
    // return (price * quantity) + calculateTax(price * quantity);
    var amount = price * quantity;
    return amount + calculateTax(amount, function() {
      if (isCanadian) {
        return 0.05;
      } else {
        return 0.0;
      }
    });
  }
