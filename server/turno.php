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
?>
{
  "status":200,
  "message":"Il turno del giocatore",
  "turno":"<?= file_get_contents('games/' . $id . '/turno'); ?>"
}