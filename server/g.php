<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://fcosma.it");

$id = $_GET["id"];
$sc = $_GET["intent"];

if (!is_dir('games/' . $id)) {
?>
{
  "status":401,
  "message":"Partita inesistente"
}
<?php
  die();
}

if ($sc == "join") {
  if (is_dir('games/' . $id) && !file_exists('games/' . $id . '/started')) {
?>
{
  "status":200,
  "message":"Gioco non ancora iniziato"
}
<?php
  } else {
?>
{
  "status":400,
  "message":"Gioco iniziato"
}
<?php
  }
} elseif ($sc == "player") {
  if (is_dir('games/' . $id) && file_exists('games/' . $id . '/turn/' . $_GET["playerid"])) {
?>
{
  "status":200,
  "message":"Giocatore nella partita"
}
<?php
  } else {
?>
{
  "status":400,
  "message":"Giocatore non nella partita"
}
<?php
  }
} elseif ($sc == "check") {
  if (is_dir('games/' . $id) && !file_exists('game/' . $id . '/finish')) {
?>
{
  "status":200,
  "message":"Gioco esistente"
}
<?php
  } else {
?>
{
  "status":400,
  "message":"Gioco inesistente"
}
<?php
  }
}

