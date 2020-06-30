<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 7</title>

   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-orange.min.css">

    <link rel="stylesheet" href="css/styles.css">
    <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
</head>

<body>

<!-- The drawer is always open in large screens. The header is always shown,
  even in small screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">

  <!-- <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
     <h1 class="mdl-layout-title"><span>CRM</span> Admin</h1>



      <div class="mdl-layout-spacer"></div>

      <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                  mdl-textfield--floating-label mdl-textfield--align-right">

        <label id="tt2" class="material-icons mdl-badge mdl-badge--overlap" data-badge="5">account_box</label>
        <div class="mdl-tooltip" for="tt2">Messages</div>

        <label id="tt3" class="material-icons mdl-badge mdl-badge--overlap" data-badge="4">notifications</label>
         <div class="mdl-tooltip" for="tt3">Notifications</div>

        <label class="mdl-button mdl-js-button mdl-button--icon"
               for="fixed-header-drawer-exp">
          <i class="material-icons">search</i>
        </label>
        <div class="mdl-textfield__expandable-holder">
          <input class="mdl-textfield__input" type="text" name="sample"
                 id="fixed-header-drawer-exp">
        </div>

      </div>
    </div>
  </header> -->
<?php
  include "header.inc.php";
  include "left.inc.php";
  include "data.inc.php";

  function outputOrderRow($file, $title, $quantity, $price){
    $amount = $quantity*$price;
    $priceF = number_format((float)$price, 2, '.', '');
    $amountF = number_format((float)$amount, 2, '.', '');
    echo "<tr><td><img src='images/books/tinysquare/$file'></td>
      <td class='mdl-data-table__cell--non-numeric'>$title</td>
      <td>$quantity</td>
      <td>$$priceF</td>
      <td>$$amountF</td>
    </tr>";
  }

?>
  <!-- <div class="mdl-layout__drawer mdl-color--blue-grey-800 mdl-color-text--blue-grey-50">
       <div class="profile">
           <img src="images/profile.jpg" class="avatar">
           <h4>John Locke</h4>
           <span>johnlocke@example.com</span>
       </div> -->

    <nav class="mdl-navigation mdl-color-text--blue-grey-300">
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">dashboard</i> Dashboard</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">message</i> Messages</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">event</i> Tasks</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">call</i> Orders</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">settings</i> Configure</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">view_list</i> Catalog</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">contacts</i> Customers</a>
        <a class="mdl-navigation__link mdl-color-text--blue-grey-300" href=""><i class="material-icons" role="presentation">insert_chart</i> Analytics</a>
    </nav>
  </div>



  <main class="mdl-layout__content mdl-color--grey-50">
    <header class="mdl-color--blue-grey-200">
      <h4>Order Summaries</h4>
      <p>Examine your customer orders</p>
    </header>
    <section class="page-content">

        <div class="mdl-grid">

          <!-- mdl-cell + mdl-card -->
          <div class="mdl-cell mdl-cell--3-col card-lesson mdl-card  mdl-shadow--2dp">
            <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
              <h2 class="mdl-card__title-text">My Orders</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <ul class="mdl-list">
                  <?php
                  for ($i=0; $i <5 ; $i++) {
                    echo "<li><a href='#'>Order $5".$i."0</a></li>";
                  }
                  ?>
                    <!-- <li ><a href="#">Order #500</a></li>
                    <li><a href="#">Order #510</a></li>
                    <li><a href="#">Order #520</a></li>
                    <li><a href="#">Order #530</a></li>
                    <li><a href="#">Order #540</a></li> -->
                </ul>
            </div>
          </div>  <!-- / mdl-cell + mdl-card -->




          <!-- mdl-cell + mdl-card -->
          <div class="mdl-cell mdl-cell--9-col card-lesson mdl-card  mdl-shadow--2dp">
            <div class="mdl-card__title mdl-color--orange">
              <h2 class="mdl-card__title-text">Selected Order: #520</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <table class="mdl-data-table  mdl-shadow--2dp">
                 <caption>Customer: <strong>Mount Royal University</strong></caption>
                  <thead>
                    <tr>
                      <th>Cover</th>
                      <th class="mdl-data-table__cell--non-numeric">Title</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tfoot>
                      <tr class="totals">
                          <td colspan="4">Subtotal</td>
                          <td><?php

                          $subtotal = $quantity1*$price1 + $quantity2*$price2 +$quantity3*$price3 + $quantity4*$price4;
                          echo "$" . number_format($subtotal,2);

                          ?>
                          </td>
                      </tr>
                      <tr class="totals">
                          <td colspan="4">Shipping</td>
                          <td><?php
                          if ($subtotal>10000){
                            $shipping = 100;
                            echo "$100.00";
                          } else{
                            $shipping = 200;
                            echo "$200.00";
                          }
                            ?></td>
                      </tr>
                      <tr class="grandtotals">
                          <td colspan="4">Grand Total</td>
                          <td><?php

                          $grandTotal = $subtotal+$shipping;
                          echo "$" . number_format($grandTotal,2);

                          ?></td>
                      </tr>
                  </tfoot>
                  <tbody>
                    <?php outputOrderRow($file1, $title1, $quantity1, $price1) ?>
                    <?php outputOrderRow($file2, $title2, $quantity2, $price2) ?>
                    <?php outputOrderRow($file3, $title3, $quantity3, $price3) ?>
                    <?php outputOrderRow($file4, $title4, $quantity4, $price4) ?>
                    <!-- <tr>
                     <td><img src="images/books/tinysquare/0205886159.jpg"></td>
                      <td class="mdl-data-table__cell--non-numeric">Global Issues, Local Arguments</td>
                      <td>25</td>
                      <td>$10.00</td>
                      <td>$250.00</td>
                    </tr>
                    <tr>
                     <td><img src="images/books/tinysquare/0205875548.jpg"></td>
                      <td class="mdl-data-table__cell--non-numeric">The Prentice Hall Guide for College Writers</td>
                      <td>50</td>
                      <td>$50.00</td>
                      <td>$2500.00</td>
                    </tr>
                    <tr>
                     <td><img src="images/books/tinysquare/0321826035.jpg"></td>
                      <td class="mdl-data-table__cell--non-numeric">Introductory and Intermediate Algebra 5e</td>
                      <td>40</td>
                      <td>$35.00</td>
                      <td>$1400.00</td>
                    </tr>
                    <tr>
                     <td><img src="images/books/tinysquare/0205902278.jpg"></td>
                      <td class="mdl-data-table__cell--non-numeric">Literature and the Writing Process</td>
                      <td>300</td>
                      <td>$20.00</td>
                      <td>$7500.00</td>
                    </tr> -->
                  </tbody>

                </table>
            </div>

          </div>  <!-- / mdl-cell + mdl-card -->




        </div>  <!-- / mdl-grid -->


    </section>
  </main>


</div>

</body>
</html>
