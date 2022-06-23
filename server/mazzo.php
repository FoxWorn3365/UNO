<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://fcosma.it");

$id = $_GET["id"];
$p = $_GET["playerid"];

if (!is_dir('games/' . $id)) {
?>
{
  "status":401,
  "message":"Partita inesistente"
}
<?php
  die();
}

$cards = explode('{}', file_get_contents('games/' . $id . '/turn/' . $p));

// Contiamo bene le sue carte
$number = 0;
foreach ($cards as $dev) {
  if (!empty($dev)) {
    $number++;
  }
}

if ($number == 0 && !file_exists('games/' . $id . '/finish') && file_exists('games/' . $id . '/started')) {
  file_put_contents('games/' . $id . '/finish', $p);
  sleep(30);
  file_get_contents('https://api.fcosma.it/uno/reset?id=' . $id);
  die();
}

?>
{
  "status":200,
  "message":"Mazzo del giocatore",
  "count":"<?= $number ?>",
  "mazzo": [
<?php
$count = 0;
foreach ($cards as $dev) {
  if ($count == count($cards)-1) {
?>
     "<?= $dev; ?>"
<?php
  } else {
?>
     "<?= $dev; ?>",
<?php
  }
  $count++;
}
?>
  ]
}