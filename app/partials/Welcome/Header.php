<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Muhammad Rayhan Faridh">
	<meta name="keywords" content="sipinrang, sistem informasi peminjaman ruang, peminjaman ruang, stis, stis.ac.id, stis.ac.id/sipinrang">
	<meta name="description" content="Sistem Informasi Peminjaman Ruang STIS">
	<base href="<?= BASE_URL ?>">
	<title>Sipinrang STIS <?php echo (isset($data['title'])) ? '|| ' . $data['title'] : ''; ?></title>

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

<body>