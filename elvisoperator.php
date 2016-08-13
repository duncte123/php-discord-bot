<?php

$test;

echo $test ?: "other\n"; // PHP Notice:  Undefined variable: test
echo $test ?? "other\n"; // other

$test = "first\n";

echo $test ?: "other\n"; // first
echo $test ?? "other\n"; // first

$array = [];

echo $array['item'] ?: "default\n"; // PHP Notice:  Undefined index: item
echo $array['item'] ?? "default\n"; // default