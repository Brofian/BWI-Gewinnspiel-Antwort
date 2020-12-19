<?php

use src\Hardware;
use src\Transporter;

/**
 * Haupt-Funktion zur Berechnung der optimalen Ladung
 *
 * @param array $transporters
 * @param array $hardware
 */
function doAlgorythmStuff(array &$transporters, array &$hardware) {


    sortHardwareByEfficiency($hardware);


    //Die Transporter werden mit der Hardware gefüllt, die den höchsten Effizienz-Wert besitzt
    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {

        /** @var Hardware $item */
        foreach($hardware as $item) {

            if($item->getRequirement() == 0) continue; //Die benötigte Anzahl der Hardware ist bereits geladen und sie wird deshalb nicht mehr benötigt -> überspringen
            if($item->getWeight() >= $transporter->getCurrentCapacity()) continue; //die Hardware ist zu schwer um geladen zu werden -> überspringen


            $maximumAmountByTransporter = (int)($transporter->getCurrentCapacity() / $item->getWeight());
            $maximumAmountByItemStock = $item->getRequirement();
            //die maximal belad-bare Anzahl der Hardware. Limitiert durch nötige Anzahl und die Transporter-Kapazität
            $totalMaximumAmount = min($maximumAmountByItemStock, $maximumAmountByTransporter);

            //Diese Anzahl der Hardware zum Transporter hinzufügen
            $transporter->addHardware($item, $totalMaximumAmount);

        }

    }



    //Prüfung, ob ein geladenes und inefficientes Teil gegen eines getauscht werden kann, das ein bisschen ineffizienter ist,
    //aber einen höheren Nutzwert hat und mehr freie kapazität füllen kann.
    // Das wird wiederholt, bis keine Verbesserung mehr gemacht wurde
    do {
        $changesMade = false;


        foreach($transporters as $transporter) {

            //Die aktuell geladene Hardware
            $cargo = $transporter->getCurrentCargoRaw();

            //Anzahl der möglichen Tausch-Optionen für diesen Transporter
            $possibleSwaps = [];


            /** @var Hardware $cargoItem */
            foreach($cargo as $cargoItem) {

                //Das Kriterium für einen sinnvollen Tausch:

                // 1) Die Kapazität nachdem der aktuelle Gegenstand entfernt wurde, muss für einen neuen reichen
                $capacityWhenRemoved = $transporter->getCurrentCapacity() + $cargoItem->getWeight();
                // 2) Der Nutzwert des neuen Gegenstandes muss höher sein, als der Alte
                $itemValue = $cargoItem->getValue();


                //die noch benötigte Hardware wird auf die gegebenen Kriterien geprüft
                /** @var Hardware $item */
                foreach($hardware as $item) {

                    //Prüfung für: 1 Gegenstand entnehmen, 1 Gegenstand hinzufügen
                    if(
                        $item->getValue() > $itemValue &&
                        $item->getWeight() <= $capacityWhenRemoved &&
                        $item->getRequirement() > 0
                    ) {
                        //Dieses Hardware-Teil ist eine gute Tausch-Option. Es wird daher zum Array hinzugefügt
                        //Gespeichert wird ein Array, bestehend aus: Item-Name, Verbesserung im Nutzwert
                        $possibleSwaps[$cargoItem->getName()] = [$item->getName(), $item->getValue() - $itemValue];

                    }
                    else {

                        //Eine zweite Prüfung für: 1 Gegenstand entnehmen, 2 Gegenstände hinzufügen
                        /** @var Hardware $itemSec */
                        foreach ($hardware as $itemSec) {

                            $value          =    $item->getValue()           +  $itemSec->getValue();
                            $weight         =    $item->getWeight()          +  $itemSec->getWeight();

                            //wenn beide Gegenstände zur selben Hardware gehören, ist die Bedingung: "mindestens zwei davon",
                            //ansonsten: "mindestens eines von jedem"
                            if($item->getName() == $itemSec->getName()) {
                                $requirement = $itemSec->getRequirement();
                            }
                            else {
                                $requirement = ($item->getRequirement() > 0)  +  ($itemSec->getRequirement() > 0);
                            }



                            //Prüfung der Kriterien für diese zwei Hardware-Teile
                            if(
                                $value > $itemValue &&
                                $weight <= $capacityWhenRemoved &&
                                $requirement >= 2
                            ) {
                                //Das wäre ein sinnvoller Tausch. Die Teile werden daher zum Array hinzugefügt
                                $possibleSwaps[$cargoItem->getName()] = [
                                    [$item->getName(), $itemSec->getName()],
                                    $value - $itemValue];
                            }
                        }

                    }


                }

            }



            if(count($possibleSwaps) >= 1) {

                //Die ermittelten Tausch-Optionen werden vom profitabelsten abwärts sortiert
                uasort($possibleSwaps, function($a, $b) {
                    return $b[1] - $a[1];
                });



                //Diese Foreach-Schleife dient nur dazu, den assoziativen Index des ersten Elements zu ermitteln,
                //und wird deshalb bereits nach dem ersten durchlauf beendet
                foreach($possibleSwaps as $cargoItemName => $swap) {

                    //Die Gegenstände werden ausgetauscht

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


                //es wurden Änderungen gemacht, die Schleife soll daher nochmals durchlaufen
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