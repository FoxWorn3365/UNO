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

// Creiamo una nuova partita
$id = rand(9, 9999) . rand(9, 9999);

mkdir('games/' . $id, 0777);
mkdir('games/' . $id . '/turn/', 0777);
file_put_contents('games/' . $id . '/center', rnmb() . '_'. rc());
?>
{
  "status":200,
  "message":"Partita creata con successo!",
  "id":<?= $id; ?>
}