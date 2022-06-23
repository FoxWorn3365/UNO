<?php
function rm_rs($dir) {
  foreach(scandir($dir) as $file) {
    if ('.' === $file || '..' === $file) continue;
    if (is_dir($dir.'/'.$file)) rm_rs($dir.'/'.$file);
    else unlink($dir.'/'.$file);
  }
  rmdir($dir);
}

header("Access-Control-Allow-Origin: https://fcosma.it");

$id = $_GET["id"];
rm_rs('games/' . $id);
?>
okj