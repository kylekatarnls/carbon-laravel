<?php

$arguments = implode(' ', $argv);

if (!preg_match('/"(?<carbon>.+)".+"(?<laravel>.+)"/U', $arguments, $match)) {
    echo "Missing arguments.\n";
    exit(1);
}

$file = __DIR__.'/composer.json';
$composer = json_decode(file_get_contents($file), true);
$composer['require']['laravel/framework'] = $match['laravel'];
$composer['require']['nesbot/carbon'] = $match['carbon'];

if (!file_put_contents($file, json_encode($composer, JSON_PRETTY_PRINT))) {
    echo "Unable to write in composer.json\n";
    exit(1);
}
echo "Dependencies updated:\n";
print_r($composer['require']);
echo "\n";
exit(0);
