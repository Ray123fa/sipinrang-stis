<?php
if (isset($data['js'])) {
	foreach ($data['js'] as $js) {
		echo "<script src='js/$js'></script>";
	}
}
?>
<script src="https://site-assets.fontawesome.com/releases/v6.5.1/js/all.js"></script>
</body>

</html>