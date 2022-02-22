<!DOCTYPE html>
<html>
  <head>
  	<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/> <!--no cache-->
		<meta http-equiv="pragma" content="no-cache" /> <!--no cache-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $simplePAGE['title'] ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Google fonts - Roboto -->
    <link href="css/opensans.css" rel="stylesheet">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css?v=1.1.2" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/ditpsd-style.css?v=1.1.10">
    <!-- Favicon-->
    <!-- <link rel="shortcut icon" href="img/favicon.ico"> -->
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <link rel="stylesheet" href="css/all.css">
    <!-- Font Icons CSS-->
    <!--<link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">-->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="lib/jquery-ui.js"></script>
    <script type="text/javascript" src="lib/jquery.numeric.js"></script>
    <script src="lib/jquery.masknumber.js"></script>
    <?php
    if(isset($_GET['mode']) && $_GET['mode']=="com_kegiatan")
    {
    	?>
    	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    	<?php
    }
    ?>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page home-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar red">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.php" class="navbar-brand">
                  <div class="brand-text brand-big hidden-lg-down"><span><?php echo $simplePAGE['title']; ?> | </span><strong>Dashboard</strong></div>
                  <div class="brand-text brand-small"><strong><?php //echo $simplePAGE['title']; ?></strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
              	<li class="nav-item">
              		<a href="<?php echo $simplePAGE['adminbasename'] . "index.php?act=site&mode=com_notification"; ?>" class="nav-link logout"><i class="fas fa-bell"></i> 
              			<?php
              			include_once('lib/notifcount.php');
              			?>
              		</a>
              	</li>
                <li class="nav-item"><a href="<?php echo $simplePAGE['adminbasename'] . "index.php?act=logout"; ?>" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <!-- <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div> -->
            <div class="title">
              <h1 class="h4">Selamat Datang <?php echo $_SESSION['realname']; ?></h1>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
          <?php include_once("levelmenu.php"); ?>
        </nav>
        <div class="content-inner">
          <!-- Page Header-->
          <!-- <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Dashboard</h2>
            </div>
          </header> -->
          <!-- Dashboard Counts Section-->
          <section>
            <div class="container-fluid">
                <?php include_once("body.php"); ?>
            </div>
          </section>
          <!-- Page Footer-->
          
        </div>
      </div>
    </div>
    
    <!-- Javascript files-->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
    
    <script>
    $(function(){
			$(".numeric").numeric();
			
			$('.currency').maskNumber({integer: true, thousands: '.'});
		});
		
		</script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"> </script>
    <script src="js/jquery.validate.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->
    <!--<script src="js/charts-home.js"></script>-->
    <script src="js/front.js"></script>
    <!-- <script src="lib/bootstrap.min.js"></script> -->
    <script src="lib/carousel.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    
    <script language="javascript" type="text/javascript">
	
		<?php	
		include_once("jscall.php");	
		?>
						
		</script>
    
  </body>
</html>