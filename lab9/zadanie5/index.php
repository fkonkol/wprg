<?php

$whitelist_filepath = "./assets/whitelist.json";

function getWhitelist($path): array {
  $js = file_get_contents($path);
  $data = json_decode($js, true);

  return $data['whitelist'];
}

$remoteAddress = $_SERVER['REMOTE_ADDR'];
$whitelist = getWhitelist($whitelist_filepath);

if (in_array($remoteAddress, $whitelist)) {
  require './views/home.html';
} else {
  require './views/stranger.html';
}
