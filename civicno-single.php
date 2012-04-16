#!/usr/bin/php -q
<?php
    /**
    * Generates a Swedish civic number from the provided arguments.
    */
    require "classes/CivicNumberGenerator.php";

    array_shift($argv);
    if (count($argv) == 0) {
        echo "Usage: php civicno-single.php YYMMDD [m|f]";
    } else {
        $dateOfBirth = $argv[0];
        $gender = count($argv) == 2 ? $argv[1] : null;

        try {
            echo CivicNumberGenerator::generate($dateOfBirth, $gender);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    exit;
?>