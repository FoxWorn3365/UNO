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

file_put_contents('games/' . $id . '/turno', $avv);
?>
{
  "status":200,
  "message":"Turno cambiato con successo!"
}
