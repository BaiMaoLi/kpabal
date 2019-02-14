<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Panel - <?=SITE_TITLE?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?=ADMIN_ASSETS_DIR?>assets/vendors/base/vendors.bundle.css">
	<link href="<?=ADMIN_ASSETS_DIR?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?=ADMIN_ASSETS_DIR?>css/main.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					<?php if($message):?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						</button>
						<?=$message?>
					</div>
					<?PHP endif ?>
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="name" placeholder="Username" value="admini">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password" value="admini">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>	
	<script src="<?=ADMIN_ASSETS_DIR?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
</body>
</html>