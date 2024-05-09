<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<base href="<?= BASE_URL ?>">
	<title>Sipinrang STIS <?php echo (isset($data['title'])) ? '|| ' . $data['title'] : ''; ?></title>

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

<body>