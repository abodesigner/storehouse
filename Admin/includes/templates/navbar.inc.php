<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN')?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('CATEGORIES')?> </a></li>
        <li><a href="items.php"><?php echo lang('ITEMS')?> </a></li>
        <li><a href="members.php"><?php echo lang('MEMBERS')?> </a></li>
        <li><a href="#"><?php echo lang('STATISTICS')?> </a></li>
        <li><a href="#"><?php echo lang('LOGS')?> </a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">aboanas
              <i class="fas fa-user-circle"></i></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>"><i class="fas fa-user-edit"></i>Edit Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#"><i class="fas fa-cog"></i>Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
