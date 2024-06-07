<?php
ini_set('display_errors', 1); // 0 in production
date_default_timezone_set('Asia/Jakarta');

if (!session_id()) {
	session_start();
}

require_once 'config/Config.php';
require_once 'core/Autoload.php';
