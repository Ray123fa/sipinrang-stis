<?php
class Flasher
{
	public static function setFlash($message, $type)
	{
		$_SESSION['flash'] = [
			'message' => $message,
			'type' => $type
		];
	}

	public static function flash()
	{
		if (isset($_SESSION['flash'])) {
			echo '<div class="d-flex justify-content-between align-items-center alert alert-' . $_SESSION['flash']['type'] . ' mb-2">'
				. $_SESSION['flash']['message'] . '
				<span class="cursor-pointer p-1" onclick="this.parentElement.style.display = \'none\'">
					<i class="fas fa-xmark"></i>
				</span>
				</div>';
			unset($_SESSION['flash']);
		}
	}
}
