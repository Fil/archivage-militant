<?php

// main script

function usage() {
	echo $argv[0]." [recipe]\n";
}

if (!strlen($recipe = $argv[1]))
	die(usage());

if (!file_exists($recipe))
	die ("Could't find recipe $recipe\n");

if (!$u = json_decode(file_get_contents($recipe), $assoc=true))
	die ("Recipe '$recipe' not in JSON format\n");


echo "Following recipe '$recipe'...\n";

if (!isset($u['script']))
	die("No script in recipe '$recipe'\n");

$script = $u['script'];

$res = `$script`;

echo $res;

echo "done\n";
