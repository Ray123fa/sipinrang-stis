<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<base href="<?= BASE_URL ?>">
	<title>Sipinrang || <?= $data['title'] ?></title>

	<?= Favicon::show() ?>

	<link rel="stylesheet" href="css/utilities.css">
	<?php
	if (isset($data['css'])) {
		foreach ($data['css'] as $css) {
			echo "<link rel='stylesheet' href='css/$css'>";
		}
	}
	?>
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
</head>

<body class="bg-gray">
	<!-- Header Start -->
	<header>
		<!-- Nav Start -->
		<nav class="d-flex justify-content-between align-items-center shadow px-4 py-2 bg-gradient-primary text-light">
			<span class="cursor-pointer unclicked" id="bar">
				<i class="fas fa-bars fs-20px"></i>
			</span>
			<div class="profile-dropdown">
				<div class="d-flex justify-content-between align-items-center">
					<img class="rounded-circle mr-2" src="<?php
																								if ($data['profile_img'] == null) {
																									echo 'img/profile.png';
																								} else {
																									echo $data['profile_img'];
																								}
																								?>" alt="Foto Profil" width="30" height="30">
					<span class="mr-2" id="user"><?= $data['unit'] ?></span>
					<i class="fas fa-caret-down mr-2" aria-hidden="true"></i>
				</div>
			</div>
		</nav>
		<!-- Nav End -->

		<ul class="d-none profile-dropdown-list list-style-none py-2">
			<?php if ($data['level'] != 4) : ?>
				<li class="px-4 mb-2 border-radius-1"><a class="d-block text-decoration-none" href="user/profile">Edit Profile</a></li>
			<?php endif; ?>
			<li class="px-4 border-radius-1"><a class="d-block text-decoration-none" href="user/logout">Logout</a></li>
		</ul>
	</header>
	<!-- Header End -->