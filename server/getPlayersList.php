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
  "message":"Membri del gruppo",
  "members": [
<?php
$count = 0;
foreach (glob('games/' . $id . '/turn/*') as $dev) {
  if ($count == 1) {
?>
      "<?= str_replace('games/' . $id . '/turn/', '', $dev); ?>"
<?php
  } else {
?>
      "<?= str_replace('games/' . $id . '/turn/', '', $dev); ?>",
<?php
  }

  $count++;
}
?>
  ]
}