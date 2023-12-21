<?php
// Retrieve values from URL parameters
$string1 = isset($_GET['string1']) ? $_GET['string1'] : '';
$string2 = isset($_GET['string2']) ? $_GET['string2'] : '';
$string3 = isset($_GET['string3']) ? $_GET['string3'] : '';

// Display variable values for debugging
echo "String1: $string1<br>";
echo "String2: $string2<br>";
echo "String3: $string3";
?>