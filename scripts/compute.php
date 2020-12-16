<?php

/**
 * Main function for computing the optimal load
 * @param array $transporters
 * @param array $hardware
 */
function doAlgorythmStuff(array &$transporters, array $hardware) {

    sortHardwareByEfficiency($hardware);

    $totalCapacity = getTotalCapacity($transporters);



    /** @var src\Transporter $transporter */
    foreach($transporters as $transporter) {

        /** @var src\Hardware $item */
        foreach($hardware as $item) {

            if($item->getRequirement() == 0) continue; //item is already completely loaded
            if($item->getWeight() >= $transporter->getCurrentCapacity()) continue; //item is to heavy for the transporter


            $maximumAmountByTransporter = (int)($transporter->getCurrentCapacity() / $item->getWeight());
            $maximumAmountByItemStock = $item->getRequirement();
            //get the maximum amount by the resulting stock and the transporter capacity
            $totalMaximumAmount = min($maximumAmountByItemStock, $maximumAmountByTransporter);

            $transporter->addHardware($item, $totalMaximumAmount);

        }


    }






}





/**
 * Sums up the capacity of all transporters
 *
 * @param array $transporters
 * @return int
 */
function getTotalCapacity(array $transporters) : int {
    $totalCapacity = 0;

    /** @var src\Transporter $transporter */
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

    /** @var src\Transporter $transporter */
    foreach($transporters as $transporter) {
        $totalCapacity += $transporter->getCurrentValue();
    }

    return $totalCapacity;
}




/**
 * Sorts the hardware by the efficiency value (value/weight) from highest to lowest
 *
 * @param array $hardware
 */
function sortHardwareByEfficiency(array &$hardware) {
    usort($hardware, function($a, $b) {
        /** @var src\Hardware $a */
        /** @var src\Hardware $b */

        //$efficiencyDiff = $b->getEfficiency() - $a->getEfficiency();
        $efficiencyDiff = $b->getEfficiency() - $a->getEfficiency();
        return (int)(1000 * $efficiencyDiff);
    });
}