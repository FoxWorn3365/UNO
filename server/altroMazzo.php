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

$co = json_decode(file_get_contents('https://api.fcosma.it/uno/getPlayersList?id=' . $id));

function avversario($co, $user) {
  foreach ($co->members as $dev) {
    if ($dev != $user) {
      return $dev;
    }
  }
  return "undefined";
}

$avv = avversario($co, $p);

$count = explode('{}', file_get_contents('games/' . $id . '/turn/' . $avv));

if (count($count) == 0 && !file_exists('games/' . $id . '/finish') && file_exists('games/' . $id . '/started')) {
  file_put_contents('games/' . $id . '/finish', $avv);
  sleep(30);
  file_get_contents('https://api.fcosma.it/uno/reset?id=' . $id);
  die();
}

$c = 0;
foreach ($count as $pt) {
  if ($pt != "") {
    $c++;
  }
}
?>
{
  "status":200,
  "message":"Numero di carte dell'avversario",
  "avversario":"<?= $avv; ?>",
  "value":<?= $c; ?>
}
