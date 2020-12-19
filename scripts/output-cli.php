<?php

use src\Hardware;
use src\Transporter;


    //Re-declare the variables as reference for the IDE
    /** @var array  $transporter */
    $transporters = $transporters ?? [];
    /** @var array  $hardware */
    $hardware = $hardware ?? [];



    echo PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;
    echo "|                      Result                          |" . PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;
    echo PHP_EOL;



    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {
        $counter = isset($counter) ? $counter++ : 1 ;

        echo "The " . $counter . ". transporter:" . PHP_EOL;


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
        echo "   - Value: " . $transporter->getCurrentValue() . PHP_EOL;
        echo "   - Unused capacity: " . $transporter->getCurrentCapacity() . "g" . PHP_EOL;

        echo PHP_EOL;
        echo PHP_EOL;

    }


    //sum the values of the transporters
    $totalValue = 0;
    foreach ($transporters as $transporter) {
        $totalValue += $transporter->getCurrentValue();
    }


    echo "--------------------------------------------------------" . PHP_EOL;
    echo " Total value: " . $totalValue . PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;

