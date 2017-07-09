<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Demo Facebook Application</title>
		<meta name="description" content="Demo facebook application" />
		<meta name="keywords" content="Facebook, application, facebook app, app, apps, fb app" />
		<meta name="author" content="Rupali Soni" />
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="clearfix">
				<h1>Facebook Application <span>Click on image for more details</span></h1>	
			</header>
			<div class="main">
				<ul id="og-grid" class="og-grid">
				<?php if(isset($_SESSION['user'])): 
					$userData = $_SESSION['user'];
				?>
					<li>
						<a href="fblogout.php"
							data-atext="Logout"
							data-largesrc="http://graph.facebook.com/<?php echo $userData['fb_id']; ?>/picture?type=large" 
							data-title="<?php echo $userData['first_name'].' '.$userData['last_name'] ; ?>" 
							data-description="Hello <?php echo $userData['first_name'].' '.$userData['last_name'] ; ?>, Have a great day ahead!">
							<img src="http://graph.facebook.com/<?php echo $userData['fb_id']; ?>/picture?type=large" alt="img01"/>
						</a>
					</li>
				<?php else: ?>
					<li>
						<a href="fblogin.php"
							data-atext="Login with Facebook"
							data-largesrc="images/1.jpg" 
							data-title="Who is Your Biggest Enemy?" 
							data-description="Do you want to know who is your real enemy in your long friend list. We can give you this information in a second. Before its too late get to know him NOW!!!">
							<img src="images/thumbs/1.jpg" alt="img01"/>
						</a>
					</li>
					<li>
						<a href="/fblogin.php"
							data-atext="Login with Facebook"
							data-largesrc="images/2.jpg" 
							data-title="Find Your Next Boyfriend!" 
							data-description="Please login with Facebook to see the result.">
							<img src="images/thumbs/2.jpg" alt="img02"/>
						</a>
					</li>
					<li>
						<a href="/fblogin.php" 
							data-atext="Login with Facebook"
							data-largesrc="images/3.jpg" 
							data-title="We Found Your Autobiography." 
							data-description="To take a look, please login with Facebook">
							<img src="images/thumbs/3.jpg" alt="img03"/>
						</a>
					</li>
				<?php endif;?>
				</ul>
				<p>Developed by <a href="mailto:rupali.soni19@gmail.com">Rupali Soni</a></p>
			</div>
		</div><!-- /container -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="js/grid.js"></script>
		<script>
			$(function() {
				Grid.init();
			});
		</script>
	</body>
</html>