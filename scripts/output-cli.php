<?php

use src\Hardware;
use src\Transporter;


    //Die Variablen werden neu deklariert, um von der IDE als Referenz genutzt werden zu können
    /** @var array  $transporter */
    $transporters = $transporters ?? [];
    /** @var array  $hardware */
    $hardware = $hardware ?? [];



    echo PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;
    echo "|                      Ergebnis                        |" . PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;
    echo PHP_EOL;



    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {
        $counter = isset($counter) ? $counter++ : 1 ;

        echo "Der " . $counter . ". Transporter:" . PHP_EOL;


        //output the loaded cargo
        foreach($transporter->getCurrentCargo() as $cargo) {
            /** @var Hardware $hardware */
            $hardware = $cargo[0];
            /** @var int $amount */
            $amount = $cargo[1];

            echo "   > " . $amount . "x " . $hardware->getName() . PHP_EOL;
        }


        //output the summary for this transporter
        echo PHP_EOL;
        echo "   - Nutzwert: " . $transporter->getCurrentValue() . PHP_EOL;
        echo "   - Ungenutze Lade-Kapazität: " . $transporter->getCurrentCapacity() . "g" . PHP_EOL;

        echo PHP_EOL;
        echo PHP_EOL;

    }


    //sum the values of the transporters
    $totalValue = 0;
    foreach ($transporters as $transporter) {
        $totalValue += $transporter->getCurrentValue();
    }


    echo "--------------------------------------------------------" . PHP_EOL;
    echo " Gesamt-Nutzwert: " . $totalValue . PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;

