<?php

$path_index = '../';
$path_config = '../config/';
$path_pages = '';
$path_classes = '../classes/';

include($path_classes . 'user.php');
include($path_classes . 'event.php');

require_once($path_config . 'config.php');

$planning = creaTableEvent(8, 13);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planning</title>
</head>

<body>
  <main>
    <table>
      <?php dispTableEvent($planning); ?>
    </table>
  </main>
</body>

</html>