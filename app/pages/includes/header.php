<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=ucfirst($URL[0])?> - Portfolios</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css?67er">
</head>
<body>

	<header>
		<div class="logo-holder">
			<a href="<?=ROOT?>"><img class="logo" src="<?=ROOT?>/assets/images/logo.jpg"></a>
		</div>
		<div class="header-div">
			<div class="main-title">
				PORTFOLIOS
				<div class="socials">


				</div>
			</div>
			<div class="main-nav">
				<div class="nav-item"><a href="<?=ROOT?>">Home</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/music">Music</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/artists">Artists</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/about">About us</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/contact">Contact us</a></div>
				
				<?php if(logged_in()):?>
					<div class="nav-item dropdown">
						<a href="#">Hi, <?=user('username')?></a>
						<div class="dropdown-list">
							<div class="nav-item"><a href="<?=ROOT?>/admin/users/edit/<?=user('id')?>">Profile</a></div>
							<div class="nav-item"><a href="<?=ROOT?>/admin">Admin</a></div>
							<div class="nav-item"><a href="<?=ROOT?>/logout">Logout</a></div>
						</div>
					</div>
				<?php endif;?>

			</div>
		</div>
	</header>