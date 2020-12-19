<?php

namespace src;

class Hardware
{

    /** @var string */
    private $name = "";
    /** @var int */
    private $required = 0;
    /** @var int */
    private $weight = 0;
    /** @var int */
    private $value = 0;
    /** @var float */
    private $efficiency = 0;


    /**
     * Hardware Konstruktor.
     * @param string $name
     * @param int $required
     * @param int $weight
     * @param int $value
     */
    public function __construct(string $name, int $required, int $weight, int $value)
    {
        $this->name = $name;
        $this->required = $required;
        $this->weight = $weight;
        $this->value = $value;

        $this->efficiency = $value / $weight;
    }




    /*
    * ##################################################
    * #             Klassen-Methoden                   #
    * ##################################################
    */


    /**
     * @param int $amount
     * @return bool
     */
    public function removeFromRequirement(int $amount): bool
    {
        if ($this->required >= $amount) {
            $this->required -= $amount;
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param int $amount
     */
    public function addToRequirement(int $amount)
    {
        $this->required += $amount;
    }






    /*
     * ##################################################
     * #             Getter-Methoden                    #
     * ##################################################
     */


    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }

    /** @return int */
    public function getRequirement(): int
    {
        return $this->required;
    }

    /** @return int */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /** @return int */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return float
     */
    public function getEfficiency(): float
    {
        return $this->efficiency;
    }


}