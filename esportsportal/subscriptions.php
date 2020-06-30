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

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Welcome home, <?php echo $_SESSION['user'];?>!</h2>
        <ol>
          <li><a href="account-info.php">Account Information</a></li>
          <li>My Subscriptions
        </li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Team Section ======= -->
  <section id="coaches" class="team section-bg">
    <div class="container">

      <div class="row">

        <?php include_once "sidebar.inc.php" ?>

        <div class="section-body-content">
            <h1 class="section-body-title">My Subscriptions</h1>
            <div class="section-body-block">
              <section class="dashboard-user-table-wrapper">
                <table class="dashboard-user-table gamer">
                  <thead>
                    <tr>
                      <th>Subscription</th>
                      <th></th>
                      <th>Hours/Credit</th>
                      <th>Renew Date</th>
                      <th>Cost</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- ngRepeat: deposit in vm.subscriptions track by $index --><tr ng-repeat="deposit in vm.subscriptions track by $index" class="ng-scope">
                      <td class="other-user-picture">
                        <!-- ngIf: !deposit.isCurrencySubscription --><span ng-if="!deposit.isCurrencySubscription" class="ng-scope">
                          <img ng-src="assets/img/arsultan.jpg" alt="SunIsFading - DOTA 2 Coach" src="assets/img/arsultan.jpg">
                        </span><!-- end ngIf: !deposit.isCurrencySubscription -->
                        <!-- ngIf: deposit.isCurrencySubscription -->
                      </td>
                      <td class="other-user-text">
                        <!-- ngIf: deposit.isCurrencySubscription -->
                        <!-- ngIf: !deposit.isCurrencySubscription --><span ng-if="!deposit.isCurrencySubscription" class="ng-binding ng-scope">
                          DOTA 2 Lessons with
                          <user-combined-name screen-name="deposit.sensei_screen_name" full-name="deposit.sensei_full_name" class="ng-isolate-scope"><!-- ngIf: screenName && fullName --><span ng-if="screenName &amp;&amp; fullName" class="ng-binding ng-scope">Maria 'SunIsFading' Merezhko</span><!-- end ngIf: screenName && fullName -->
        <!-- ngIf: screenName && !fullName -->
        <!-- ngIf: !screenName && fullName --></user-combined-name>
                        </span><!-- end ngIf: !deposit.isCurrencySubscription -->

                      </td>
                      <td class="hours ng-binding">
                        1
                      </td>
                      <td ng-class="{ 'inactive': deposit.status === 'inactive' }" class="ng-binding">
                        05/04/2020
                        <br>

                        <br>
                        <!-- ngIf: deposit.isEligible --><!-- end ngIf: deposit.isEligible -->
                      </td>
                      <td class="ng-binding">
                        $87.50
                      </td>
                    </tr><!-- end ngRepeat: deposit in vm.subscriptions track by $index -->
                  </tbody>
                </table>
              </section>
              <span class="u-pull-right muted small">If you would like to make a change to your subscription, please contact us at <a class="blue-link" href="mailto:cs@esportsportal.com">cs@esportsportal.com</a></span>
            </div>
          </div>
        </div>
      </div>
    </section>
<style>
.dashboard-content .section-body {
    position: relative;
    display: block;
}
.dashboard-content .section-body, .dashboard-content .section-header {
    min-width: 0;
    margin: 0 auto;
}
.section-body-block {
    font-size: 16px;
    line-height: 24px;
    font-weight: 500;
}
.dashboard-user-table-wrapper {
    padding: 15px;
    border: 1px solid #ECECED;
    margin-bottom: 10px;
}
.dashboard-user-table-wrapper .dashboard-user-table td.other-user-picture {
    width: 10%;
    max-width: 10%;
    text-align: center;
}
.dashboard-user-table-wrapper .dashboard-user-table td.other-user-picture img {
    display: block;
    width: 100%;
    height: auto;
}
.dashboard-user-table-wrapper .dashboard-user-table {
    width: 100%;
}
.table {
    border-collapse: collapse;
    border-spacing: 0;
}
</style>

</main><!-- End #main -->

<?php include_once "footer.inc.php" ?>
