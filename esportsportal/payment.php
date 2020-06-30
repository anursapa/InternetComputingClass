<?php include_once "header.inc.php";

$sql = "Select * from user_dim where UserName ='".$_SESSION['user']."'";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
       // output data of each row
       while($row = mysqli_fetch_assoc($result)) {
           $userEmail = $row["UserEmail"];
           $mainGame = $row["UserMainGame"];}
   } else {
       echo "There is nothing to loan at the moment";
   }

   mysqli_close($conn);
?>

<main id="main">

<br>
<br>
<br>
<br>
<br>
<br>
<br>

  <!-- ======= Features Section ======= -->
  <section id="features" class="features">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Payment</h2>
        <p>Click the button below to login and pay with your Paypal account.</p>
      </div>

<center data-aos="fade-up">
    <script src="https://www.paypal.com/sdk/js?client-id=AXFHdJuK6p6xB-Gi0icA3x-1b-uuJPmX_DdQ34jYzmaOFlfgVie_4d8099if-AFy9R1ldRS9bBOsPRje"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
    </script>

    <div id="paypal-button-container"></div>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({

            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '0.01'
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
                    alert('Transaction completed by ' + details.payer.name.given_name + '!');
                    window.location.href = "payment-success.php";
                });
            },
            onCancel: function (data, actions) {
                // Show a cancel page or return to cart
                window.location.href = "payment-failure.php";
            }


        }).render('#paypal-button-container');
    </script>


    </div>
  </section><!-- End Features Section -->
</center>

<br>
<br>
<br>
<br>
<br>

</main><!-- End #main -->

<?php include_once "footer.inc.php" ?>
