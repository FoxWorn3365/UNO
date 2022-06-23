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
  $a = rand(0, 11);
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

if (json_decode(file_get_contents('https://api.fcosma.it/uno/g?intent=player&id=' . $id . '&playerid=' . $p))->status == 400 && count(glob('games/' . $id . '/turn/*')) < 2) {
  file_put_contents('games/' . $id . '/turno', $p);
  // Carichiamo le carte
  $inv = rnmb() . '_' . rc();
  for ($a = 0; $a < 6; $a++) {
    $inv = $inv . '{}' . rnmb() . '_' . rc();
  }

  file_put_contents('games/' . $id . '/turn/' . $p, $inv);
?>
{
  "status":200,
  "message":"Giocatore '<?= $p; ?>' entrato in partita"
}
<?php
} else {
?>
{
  "status":400,
  "message":"Il giocatore era già presente / Partita piena"
}
<?php
}
?>