<?php

namespace ericfelder\BaseNumber;

use Exception;

/**
 * BaseNumber Class
 *
 * BaseNumber can be used to convert numbers of different bases to the same format.
 *
 * @author  Eric Felder <ericfelder@me.com>
 */

class BaseNumber
{
    private $Decimal;
    private $BaseString;
    private $Base;
    private $Values = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i',
        'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
        'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    /**
     * Converts a number from a decimal to the specified base format (2-36)
     *
     * @param int $decimal Decimal number to be converted
     * @param int $base Base of the number to be converted to
     * @return string Number converted to base in string format
     * @throws \Exception Cannot convert number to non-numeric base - Thrown if non-numeric base is used
     */
    private function decimalToBaseNum($decimal, $base)
    {
        if (!is_numeric($base)) {
            throw new Exception('Cannot convert number to non-numeric base.');
        } elseif ($base != floor($base)) {
            throw new Exception('Base must be a whole number.');
        } elseif (($base < 0) || ($base > 62)) {
            throw new Exception('Cannot convert number to negative base.');
        } elseif ($base == 1) {
            throw new Exception('Cannot convert number to base 1.');
        } elseif ($base > 62) {
            throw new Exception('Cannot convert number to base larger than 62.');
        } elseif (!is_numeric($decimal)) {
            throw new Exception('Cannon convert non-numeric number to base.');
        } elseif ($decimal != floor($decimal)) {
            throw new Exception('Number to convert must be a whole number.');
        } elseif ($decimal < 0) {
            throw new Exception('Cannot convert negative number to base.');
        } else {
            $number = '';
            while ($decimal / $base >= 1) {
                $rem = $decimal % $base;
                $number = $this->Values[$rem] . $number;
                $decimal -= $rem;
                $decimal /= $base;
            }
            $number = $this->Values[$decimal] . $number;

            return $number;
        }
    }

    /**
     * Finds the specified value inside and array and returns the index of that value
     *
     * @param $array Array passed to function
     * @param $value Data you are searching for in $array
     * @return int Index of $value in $array
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

    private function baseNumToDecimal($baseNumber, $base)
    {
        $decimal = 0;
        $stringLength = strlen($baseNumber);
        for ($i = 0; $i < $stringLength; $i++) {
            $lastChar = substr($baseNumber, -1);
            $index = $this->getIndexOfValue($this->Values, $lastChar);
            if ($index === null) {
                throw new Exception('Not all characters used in base character set.');
            } elseif ($index >= $base) {
                throw new Exception('Not all characters used in base character set.');
            }
            $decimal += ($index * pow($base, $i));
            $baseNumber = substr($baseNumber, 0, -1);
        }

        return $decimal;
    }

    /**
     * Gets the base the of the number to be converted
     *
     * @return int Base of the number to be converted
     * @throws \Exception Base cannot contain an empty value - Thrown if base currently does not contain a value
     */
    public function getBase()
    {
        if (!isset($this->Base)) {
            throw new Exception('Base cannot contain an empty value.');
        } else {
            return $this->Base;
        }
    }

    public function getBaseString()
    {
        if (!isset($this->BaseString)) {
            throw new Exception('Base string cannot contain an empty value.');
        } else {
            return $this->BaseString;
        }
    }

    public function getBinary() {
        if ((isset($this->Base)) && ($this->Base === 2) && ((isset($this->Decimal)) || (isset($this->BaseString)))) {
            return $this->BaseString;
        } elseif (isset($this->Decimal)) {
            return $this->decimalToBaseNum($this->Decimal, 2);
        } elseif (isset($this->BaseString)) {
            return $this->decimalToBaseNum($this->baseNumToDecimal($this->BaseString, 2), 2);
        } else {
            throw new Exception('Cannot convert an empty number to binary.');
        }
    }

    public function getDecimal()
    {
        if (!isset($this->Decimal)) {
            throw new Exception('Decimal cannot contain an empty value.');
        } else {
            return $this->Decimal;
        }
    }

    public function getHexadecimal() {
        if ((isset($this->Base)) && ($this->Base === 16) && ((isset($this->Decimal)) || (isset($this->BaseString)))) {
            return $this->BaseString;
        } elseif (isset($this->Decimal)) {
            return $this->decimalToBaseNum($this->Decimal, 16);
        } elseif (isset($this->BaseString)) {
            return $this->decimalToBaseNum($this->baseNumToDecimal($this->BaseString, 16), 16);
        } else {
            throw new Exception('Cannot convert an empty number to hexadecimal.');
        }
    }

    public function setBase($base)
    {
        $this->Base = $base;
        if (isset($this->Decimal)) {
            $this->BaseString = $this->decimalToBaseNum($this->Decimal, $this->Base);
        } elseif (isset($this->BaseString)) {
            $this->Decimal = $this->baseNumToDecimal($this->BaseString, $this->Base);
        }
    }

    public function setBaseString($baseString)
    {
        $this->BaseString = $baseString;
        if (isset($this->Base)) {
            $this->Decimal = $this->baseNumToDecimal($this->BaseString, $this->Base);
        }
    }

    public function setDecimal($decimal)
    {
        $this->Decimal = $decimal;
        if (isset($this->Base)) {
            $this->BaseString = $this->decimalToBaseNum($this->Decimal, $this->Base);
        }
    }
}