#!/usr/bin/php -q
<?php
    require "classes/CivicNumberGenerator.php";

    if ($argc < 2 || $argc > 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
        ?>
This is a command line PHP script used to generate a valid
Swedish civic number from the provided date and/or gender.

Usage:
<?php echo $argv[0]; ?> <dateOfBirth> <gender>

<dateOfBirth> the date of birth of the person formatted as 'YYYYMMDD'
<gender> the gender of the person can either be 'm' for male or 'f' for female (random by default)
        <?php
    } else {
        array_shift($argv);

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