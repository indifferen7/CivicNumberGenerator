#!/usr/bin/php -q
<?php
    require "classes/CivicNumberGenerator.php";

    array_shift($argv);
    if (count($argv) == 0) {
        echo "Usage: php civicno-single.php YYYYMMDD [m|f]";
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