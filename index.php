<?php

$fileJson = file_get_contents(__DIR__ . "/lffsant.json");

$oauth = json_decode($fileJson);
print_r($oauth);