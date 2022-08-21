<?php require_once $_ENV['CONFIG_PATH'] . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>The University</title>
</head>
<body>
<?php if ($_SERVER['PHP_SELF'] !== '/index.php'): ?>
    <a href="/">Main menu</a>
<?php endif; ?>
