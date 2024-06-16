<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<base href="<?= BASE_URL ?>">
	<title>Sipinrang || <?= $data['title'] ?></title>

	<?= Favicon::show() ?>

	<!-- Preconnect -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

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

<body class="bg-gradient-primary">
	<div class="wrapper bg-gradient-primary">
		<div class="box bg-light shadow">
			<div class="logo">
				<img src="img/logo.png" alt="Logo STIS" width="75">
			</div>
			<div class="my-6">
				<div class="fw-bold text-center text-primary">Sistem Informasi Peminjaman Ruang</div>
			</div>

			<?php Flasher::flash(); ?>