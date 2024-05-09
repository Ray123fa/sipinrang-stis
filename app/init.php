<?php

if (!session_id()) {
	session_start();
}

require_once 'config/Config.php';
require_once 'core/Autoload.php';
