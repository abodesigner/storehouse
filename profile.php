  <?php
  	session_start();
    $pageTitle = 'Profile';
  	include 'init.php';
  ?>

      <h1 class="text-center">MY PROFILE</h1>
      <div class="information block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
            <div class="panel-body">
              Name : medhat
            </div>
          </div>
        </div>
      </div>

      <div class="my-ads block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">
              Test Ads
            </div>
          </div>
        </div>
      </div>

      <div class="my-comments block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Comments</div>
            <div class="panel-body">
              Test comment
            </div>
          </div>
        </div>
      </div>

  <?php
    include $tpl . 'footer.inc.php';
  ?>
