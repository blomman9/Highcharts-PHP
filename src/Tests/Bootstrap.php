<?php
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
	require __DIR__ . '/../../vendor/autoload.php'; // Outside vendor
} elseif (file_exists(__DIR__ . '/../../autoload.php')) {
	require __DIR__ . '/../../autoload.php'; // Inside vendor
} else {
	die('Did you installed vendors with composer?');
}