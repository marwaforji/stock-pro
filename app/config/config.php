<?php
session_start();
define('BASE_URL', '/stock-pro/public');
define('CURRENT_URL', $_GET['url'] ?? 'dashboard');
