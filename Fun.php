<?php
function readInput() {
    $fp = fopen('php://stdin', 'r');
    $input = fgets($fp, 255);
    fclose($fp);
    $input = trim($input);
    $input = filter_var($input, FILTER_SANITIZE_ADD_SLASHES );
    return $input;
}
