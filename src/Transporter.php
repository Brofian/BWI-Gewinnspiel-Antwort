<?php


namespace src;


class Transporter
{
    /** @var int  */
    const MAX_CAPACITY = 1100000;


    /** @var int  */
    private $driverWeight = 0;
    /** @var array  */
    private $cargo = [];




    /**
     * Transporter constructor.
     * @param int $driverWeight
     */
    public function __construct(int $driverWeight)
    {
        $this->driverWeight = $driverWeight;
    }





    /*
    * ##################################################
    * #                 Class-methods                  #
    * ##################################################
    */




    /**
     * Adds an $amount of $hardware to the transporter. Returns, wether or not the hardware could be loaded to the transporter
     *
     * @param Hardware $hardware
     * @param int $amount
     * @return bool
     */
    public function addHardware(Hardware &$hardware, int $amount) : bool {

        $newWeight = $hardware->getWeight() * $amount;


        if($this->getCurrentCapacity() < $newWeight) {
            //not enough space for the new hardware -> cancel
            return false;
        }
        else {
            //enough space -> store the hardware
            if(isset($this->cargo[$hardware->getName()])) {
                //the hardware is already loaded, add $amount on top
                $this->cargo[$hardware->getName()][1] += $amount;
            }
            else {
                //add a new entry for the hardware
                $this->cargo[$hardware->getName()] = [$hardware, $amount];
            }

            //remove the loaded hardware from the hardware´s stock
            $hardware->removeFromRequirement($amount);

            return true;
        }
    }


    /**
     * Remove the $amount of $hardware from the cargo. Returns, wether or not the hardware could be removed
     *
     * @param Hardware $hardware
     * @param int $amount
     * @return bool
     */
    public function removeHardware(Hardware &$hardware, $amount = 1) : bool {

        //if the hardware is stored and enough of it, remove the amount
        if(isset($this->cargo[$hardware->getName()]) && $this->cargo[$hardware->getName()][1] >= $amount) {

            //remove hardware from cargo
            $this->cargo[$hardware->getName()][1] -= $amount;

            //when there is no loaded $hardware in the cargo, remove the entry
            if($this->cargo[$hardware->getName()][1] <= 0) {
                unset($this->cargo[$hardware->getName()]);
            }

            //add the removed hardware back to the stock
            $hardware->addToRequirement($amount);

            return true;
        }
        else {
            return false;
        }

    }









    /*
     * ##################################################
     * #             Get-methods                        #
     * ##################################################
     */





    /**
     * Returns the current capacity of the transporter, that can be filled with more hardware
     *
     * @return int
     */
    public function getCurrentCapacity() : int {
        $currentLoad = 0;

        foreach($this->cargo as $cargo) {
            /** @var Hardware $hardware */
            $hardware = $cargo[0];
            /** @var int $amount */
            $amount = $cargo[1];

            $currentLoad += $hardware->getWeight() * $amount;
        }

        return (self::MAX_CAPACITY - $this->driverWeight - $currentLoad);
    }




    /**
     * Sums up and returns the value of the current load (value = usage-value)
     *
     * @return int
     */
    public function getCurrentValue() : int {
        $totalValue = 0;

        foreach($this->cargo as $cargo) {
            /** @var Hardware $hardware */
            $hardware = $cargo[0];
            /** @var int $amount */
            $amount = $cargo[1];

            $totalValue += $hardware->getValue() * $amount;
        }

        return $totalValue;
    }




    /**
     * Returns the current load
     *
     * @return array
     */
    public function getCurrentCargo() : array{
        return $this->cargo;
    }




    /**
     * Returns only an array of the stored hardware without any information about the amount
     *
     * @return array
     */
    public function getCurrentCargoRaw() : array {
        $hardware = [];

        foreach($this->cargo as $cargo) {
            $hardware[] = $cargo[0];
        }

        return $hardware;
    }




    /**
     * @return int
     */
    public function getDriverWeight() {
        return $this->driverWeight;
    }


}