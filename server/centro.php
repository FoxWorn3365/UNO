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

$centro = file_get_contents('games/' . $id . '/center');
?>
{
  "status":200,
  "message":"Carta al centro",
  "card":"<?= $centro; ?>"
}