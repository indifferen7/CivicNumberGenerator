<?php
/**
 * Generates a Swedish civic number based on the input.
 */
class CivicNumberGenerator {
    private static $pattern = "/^[1-2][0-9]{3}[0-1][0-9][0-3][0-9]$/";

    /**
     * Generates a civic number for a person with the provided $dateOfBirth and $gender.
     * @param $dateOfBirth - the date of birth. Muste be a date formatted as YYYYMMDD
     * @param null $gender - the gender of the person. Must be either 'm' or 'f' (optional)
     * @return string - the generated civic number formatted as YYYYMMDD-NNNN
     */
    public static function generate($dateOfBirth, $gender = null) {
        CivicNumberGenerator::validate($dateOfBirth);

        if ($gender == null) {
            $gender = rand(0,1) == 0 ? "m" : "f";
        }

        $controlNumbers = rand(0,9)
            .rand(0,9)
            .CivicNumberGenerator::generateGenderDigitFrom($gender);

        $source = substr($dateOfBirth, 2, strlen($dateOfBirth)) . $controlNumbers;

        $controlNumbers .= CivicNumberGenerator::generateControlNumberFrom($source);

        return $dateOfBirth . "-" . $controlNumbers;
    }

    private static function generateGenderDigitFrom($gender) {
        $gender = strtolower($gender);

        if ($gender == "m") {
            return rand(0, 4) * 2;
        } else if ($gender == "f") {
            return rand(0,4) * 2 + 1;
        }
        throw new Exception("Invalid gender: must be either 'm' or 'f'");
    }

    private static function generateControlNumberFrom($source) {
        $sum = 0;
        $factor = 2;

        foreach (array_reverse(str_split($source)) as $digits) {
            foreach (str_split($digits * $factor) as $product) {
                $sum += $product;
            }
            $factor = $factor == 2 ? 1 : 2;
        }

        $closestTen = $sum;
        while (true) {
            if ($closestTen % 10 == 0) {
                return $closestTen - $sum;
            }
            $closestTen++;
        }
    }

    private static function validate($dateOfBirth) {
        if ($dateOfBirth == null) {
            throw new InvalidArgumentException("Date of birth was null, aborting");
        }
        if (preg_match(CivicNumberGenerator::$pattern, $dateOfBirth) == 0) {
            throw new InvalidArgumentException("Expected argument format 'YYYYMMDD' but got '" . $dateOfBirth . "'");
        }
    }
}