#!/usr/bin/php -q
<?php
    error_reporting(E_ALL); ini_set("display_errors", 1);
    require "classes/CivicNumberGenerator.php";

    if ($argc < 2 || $argc > 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
        ?>
This is a command line PHP script used to generate a set of Swedish civic numbers of a given age.

Usage:
<?php echo $argv[0]; ?> <age> <amount>

<age> the age of the person(s) to generate
<amount> the amount of person(s) of <age> to generate (default 1)
        <?php
    } else {
        $age = $argv[1];
        $amount = count($argv) == 3 ? $argv[2] : 1;

        $result = array();
        for ($i = 0; $i < $amount; $i++) {
            $maxDob = strtotime('-'. $age .' years');
            $minDob = strtotime('-1 year +1 day', $maxDob);
            $dob = rand($minDob, $maxDob);

            array_push($result,
                CivicNumberGenerator::generate(date("Ymd", $dob)));
        }
        echo implode(",", $result);
    }
    exit;
?>