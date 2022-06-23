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


if (file_exists('games/' . $id . '/finish')) {
?>
{
  "status":200,
  "message":"Partita terminata",
  "winner":"<?= file_get_contents('games/' . $id . '/finish'); ?>"
}
<?php
} else {
?>
{
  "status":400,
  "message":"Partita ancora in corso"
}
<?php
}
?>

