<?php
function rc() {
  $a = rand(1, 4);
  if ($a == 1) {
    return 'red';
  } elseif ($a == 2) {
    return 'green';
  } elseif ($a == 3) {
    return 'yellow';
  } elseif ($a == 4) {
    return 'blue';
  }
}

function rnmb() {
  $a = rand(0, 12);
  if ($a < 10) {
    return $a;
  } elseif ($a == 10) {
    return 'turn';
  } elseif ($a == 11) {
    return 'none';
  } elseif ($a == 12) {
    return 'plus';
  }
}

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://fcosma.it");

$id = $_GET["id"];
$p = $_GET["playerid"];

file_put_contents('games/' . $id . '/turn/' . $p, file_get_contents('games/' . $id . '/turn/' . $p) . '{}' . rnmb() . '_' . rc());
?>
{
  "status":200,
  "message":"Carta pescata!"
}