<?php
namespace DebugBar;

require 'vendor/autoload.php';

use DebugBar\StandardDebugBar;
use DebugBar\DataCollector\PDO\PDOCollector;

$debugbar = new StandardDebugBar();
$debugbarRenderer = $debugbar->getJavascriptRenderer();

$pdo = new \PDO('mysql:host=tmdsv2.cyw3t2arq3fo.us-east-1.rds.amazonaws.com;dbname=egali_tm_dsv', 'admin', 'pbmTn9xGwiZ2i51VkuTWQ');
$pdoCollector = new PDOCollector($pdo);
$debugbar->addCollector($pdoCollector);

$stmt = $pdo->prepare('SELECT * FROM tmbusiness');
$stmt->execute();
$pdoCollector->addQuery('SELECT * FROM tmbusiness', $stmt->fetchAll());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $debugbarRenderer->renderHead() ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DebugBar Example</title>
</head>
<body>
    <?php echo $debugbarRenderer->render() ?>
</body>
</html>
