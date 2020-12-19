<?php

use src\Hardware;
use src\Transporter;

/**
 * Main function for computing the optimal load
 * @param array $transporters
 * @param array $hardware
 */
function doAlgorythmStuff(array &$transporters, array &$hardware) {


    sortHardwareByEfficiency($hardware);


    //Fill the transporters with the most efficient hardware
    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {

        /** @var Hardware $item */
        foreach($hardware as $item) {

            if($item->getRequirement() == 0) continue; //item is already completely loaded and not required anymore -> skip it
            if($item->getWeight() >= $transporter->getCurrentCapacity()) continue; //one item is already to heavy for the transporter -> skip it


            $maximumAmountByTransporter = (int)($transporter->getCurrentCapacity() / $item->getWeight());
            $maximumAmountByItemStock = $item->getRequirement();
            //get the maximum amount, limited by the resulting stock and the transporter capacity
            $totalMaximumAmount = min($maximumAmountByItemStock, $maximumAmountByTransporter);

            //add this amount from this hardware to the transporter
            $transporter->addHardware($item, $totalMaximumAmount);

        }

    }




    //check, if an inefficient, loaded item can be swapped with a slightly more inefficient, but more valuable item
    //repeat this, until there is no improvement done
    do {
        $changesMade = false;



        foreach($transporters as $transporter) {

            //the currently loaded cargo
            $cargo = $transporter->getCurrentCargoRaw();

            //gather the possible swaps in this array
            $possibleSwaps = [];


            /** @var Hardware $cargoItem */
            foreach($cargo as $cargoItem) {

                //the criteria for a rational swap:
                // 1) the capacity after the element is removed, has to be enough for the new item
                $capacityWhenRemoved = $transporter->getCurrentCapacity() + $cargoItem->getWeight();
                // 2) the value of the new item has to be bigger than the old item
                $itemValue = $cargoItem->getValue();


                //check the required hardware items by the given criteria
                /** @var Hardware $item */
                foreach($hardware as $item) {

                    //check the criteria for this one hardware item
                    if(
                        $item->getValue() > $itemValue &&
                        $item->getWeight() <= $capacityWhenRemoved &&
                        $item->getRequirement() > 0
                    ) {
                        //this item would be good to swap, so add it to the array
                        $possibleSwaps[$cargoItem->getName()] = [$item->getName(), $item->getValue() - $itemValue];


                    }
                    else {

                        //start a second loop, to check for a combination from the two hardware items
                        /** @var Hardware $itemSec */
                        foreach ($hardware as $itemSec) {

                            $value          =    $item->getValue()           +  $itemSec->getValue();
                            $weight         =    $item->getWeight()          +  $itemSec->getWeight();

                            //if both items are the same, then the requirement is "at least two of them", else "at least one of each"
                            if($item->getName() == $itemSec->getName()) {
                                $requirement = $itemSec->getRequirement();
                            }
                            else {
                                $requirement = ($item->getRequirement() > 0)  +  ($itemSec->getRequirement() > 0);
                            }



                            //check the criteria for this two hardware items
                            if(
                                $value > $itemValue &&
                                $weight <= $capacityWhenRemoved &&
                                $requirement >= 2
                            ) {
                                //this items would be good to swap, so add them to the array
                                $possibleSwaps[$cargoItem->getName()] = [
                                    [$item->getName(), $itemSec->getName()],
                                    $value - $itemValue];
                            }
                        }

                    }


                }

            }



            if(count($possibleSwaps) >= 1) {

                //sort the possible swaps by the most profitable (best swap = first element in the array)
                uasort($possibleSwaps, function($a, $b) {
                    return $b[1] - $a[1];
                });



                //this foreach loop is just used to get the associated index, so break from it after the first element
                foreach($possibleSwaps as $cargoItemName => $swap) {
                    //swap the items
                    $transporter->removeHardware($hardware[$cargoItemName], 1);

                    if(is_array($swap[0])) {
                        $transporter->addHardware($hardware[$swap[0][0]], 1);
                        $transporter->addHardware($hardware[$swap[0][1]], 1);
                    }
                    else {
                        $transporter->addHardware($hardware[$swap[0]], 1);
                    }



                    break;
                }

                $changesMade = true;

            }

        }

    }
    while($changesMade);

}









/**
 * Sums up the capacity of all transporters
 *
 * @param array $transporters
 * @return int
 */
function getTotalCapacity(array $transporters) : int {
    $totalCapacity = 0;

    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {
        $totalCapacity += $transporter->getCurrentCapacity();
    }

    return $totalCapacity;
}



/**
 * Sums up the capacity of all transporters
 *
 * @param array $transporters
 * @return int
 */
function getTotalValue(array $transporters) : int {
    $totalCapacity = 0;

    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {
        $totalCapacity += $transporter->getCurrentValue();
    }

    return $totalCapacity;
}






/**
 *  Sorts the hardware by the given value
 *
 * @param array $hardware
 */
function sortHardwareByEfficiency(array &$hardware) {
    uasort($hardware, function($a, $b) {
        /** @var Hardware $a */
        /** @var Hardware $b */

        $diff = $b->getEfficiency() - $a->getEfficiency();

        //usort needs an integer above, equal or higher than zero
        return (int)(1000 * $diff);
    });

}