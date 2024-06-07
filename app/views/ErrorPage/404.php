<?php http_response_code(404); ?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<base href="<?= BASE_URL ?>">
	<title>404 Not Found</title>

	<?= Favicon::show() ?>

	<link rel="stylesheet" href="css/utilities.css">
</head>

<body class="p-2 bg-gradient-primary text-light">
	<div style="height: 100vh;" class="d-flex justify-content-center align-items-center flex-column text-center">
		<h1 style="font-size: 3rem;">404 Not Found</h1>
		<p style="font-size: 1.25rem;">Halaman yang Anda cari tidak ditemukan.</p>
	</div>
</body>

</html>