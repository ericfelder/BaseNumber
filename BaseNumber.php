<?php

namespace ericfelder\BaseNumber;

use Exception;

/**
 * BaseNumber Class
 *
 * BaseNumber can be used to convert a number between multiple bases, from 2-62
 *
 * @author Eric Felder <ericfelder@me.com>
 */

class BaseNumber
{
	private $Decimal;
	private $Values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
        'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
        'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    //NEED TO REWRITE EXCEPTIONS TO CUSTOM EXCEPTIONS
    /**
     * Converts a number from the specified base (2-62) to decimal
     *
     * @param 	string 		$baseNumber Number to be converted
     * @param 	int 		$base Base of number to be converted
     *
     * @return 	int 		Decimal form of number inputted
     *
     * @throws 	\Exception 	Not all characters suded in base character set - Thrown if invalid characters used
     */
    private function baseNumToDecimal($number, $base)
    {
    	$decimal = 0;
    	$stringLength = strlen($number);
    	for ($i = 0; $i < $stringLength; $i++) {
    		$lastChar = substr($number, -1);
    		$index = $this->getIndexOfValue($this->Values, $lastChar);
    		if ($index === null) {
                throw new Exception('Not all characters used in base character set.');
            } elseif ($index >= $base) {
                throw new Exception('Not all characters used in base character set.');
            }
            $decimal += ($index * pow($base, $i));
            $baseNumber = substr($baseNumber, 0, -1);
    	}
    }

    /**
     * Finds the specified value inside and array and returns the index of that value
     *
     * @param 	$array 	Array passed to function
     * @param 	$value 	Data you are searching for in $array
     *
     * @return 	int 	Index of $value in $array
     */
    private function getIndexOfValue($array, $value)
    {
        $index = 0;
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] === $value) {
                $index = $i;
                break;
            }
        }

        return $index;
    }
}