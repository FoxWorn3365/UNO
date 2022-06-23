<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://fcosma.it");

$id = $_GET["id"];
$p = $_GET["playerid"];
$c = $_GET["card"];


if (!is_dir('games/' . $id)) {
?>
{
  "status":401,
  "message":"Partita inesistente"
}
<?php
  die();
}

// Ora recuperiamo una carta
$card = explode('_', $c);
$center = explode('_', file_get_contents('games/' . $id . '/center'));

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

if ($card[0] == $center[0] || $card[1] == $center[1] || $card[0] == "color" || $card[0] == "plus") {


  if ($card[0] == "plus" && !empty($card[1])) {
    // Pesca due carte
    file_get_contents('https://api.fcosma.it/uno/pesca?id=' . $id . '&playerid=' . $avv);
    file_get_contents('https://api.fcosma.it/uno/pesca?id=' . $id . '&playerid=' . $avv);
  }

  file_put_contents('games/' . $id . '/turn/' . $p, str_replace("{}{}{}", "{}", str_replace($c, '', file_get_contents('games/' . $id . '/turn/' . $p))));

  file_put_contents('games/' . $id . '/center', $c);
?>
{
  "status":200,
  "message":"Carta messa con successo!"
}
<?php
} else {
  die("NO - $card[0] - $card[1]");
}
