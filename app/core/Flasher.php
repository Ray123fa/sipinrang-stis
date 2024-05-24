<?php
class Flasher
{
	public static function setFlash($message, $type, $place = null)
	{
		$_SESSION['flash'] = [
			'message' => $message,
			'type' => $type,
			'place' => $place
		];
	}

	public static function flash($for = null)
	{
		if (isset($_SESSION['flash'])) {
			if ($_SESSION['flash']['place'] == $for) {
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
}
