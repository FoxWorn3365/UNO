<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://fcosma.it");

$id = $_GET["id"];

if (!is_dir('games/' . $id)) {
?>
{
  "status":401,
  "message":"Partita inesistente"
}
<?php
  die();
}

// Piccolo check
if (count(glob('games/' . $id . '/turn/*')) == 2) {
  file_put_contents('games/' . $id . '/started', date('d/m/Y - H:i:s'));
}

if (file_exists('games/' . $id . '/started')) {
?>
{
  "status":200,
  "message":"Gioco iniziato"
}
<?php
} else {
?>
{
  "status":400,
  "message":"Gioco non iniziato"
}
<?php
}
?>
