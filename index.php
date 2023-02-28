<?php
namespace DebugBar;

require 'vendor/autoload.php';

use DebugBar\StandardDebugBar;
use DebugBar\DataCollector\PDO\PDOCollector;

$debugbar = new StandardDebugBar();
$debugbarRenderer = $debugbar->getJavascriptRenderer();

$pdo = new \PDO('mysql:host=tmdsv2.cyw3t2arq3fo.us-east-1.rds.amazonaws.com;dbname=egali_tm_dsv', 'admin', 'bmTn9xGwiZ2i51VkuTWQ');
$pdoCollector = new PDOCollector($pdo);
$debugbar->addCollector($pdoCollector);

$stmt = $pdo->prepare('SELECT * FROM tmbusiness WHERE business_id = 1');
$stmt->execute();

$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$debugbar["messages"]->addMessage($result);
$debugbar["time"]->startMeasure('render', 'Time for page render');

if (isset($_GET['test'])) {
    $debugbar["messages"]->addMessage($_GET['test']);
}

try {
    throw new \Exception('This is a test exception');
} catch (\Exception $e) {
    $debugbar["exceptions"]->addException($e);
}

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