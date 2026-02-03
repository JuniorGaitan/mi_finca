<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "PHP FUNCIONA<br>";

include __DIR__ . '/includes/header.php';

echo "HEADER OK<br>";

include __DIR__ . '/includes/sidebar.php';

echo "SIDEBAR OK<br>";

include __DIR__ . '/includes/footer.php';

echo "FOOTER OK<br>";
