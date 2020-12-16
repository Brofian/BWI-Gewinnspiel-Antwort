<?php

use src\Hardware;
use src\Transporter;


//Re-deklare the variables for better usage
    /** @var array  $transporter */
    $transporters = $transporters ?? [];
    /** @var array  $hardware */
    $hardware = $hardware ?? [];


    echo "--------------------------------------------------------" . PHP_EOL;
    echo "|                      Result                          |" . PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;



    $counter = 0;

    /** @var Transporter $transporter */
    foreach($transporters as $transporter) {
        $counter++;

        echo "The " . $counter . ". transporter:" . PHP_EOL;


        foreach($transporter->getCurrentCargo() as $cargo) {
            /** @var Hardware $hardware */
            $hardware = $cargo[0];
            /** @var int $amount */
            $amount = $cargo[1];

            echo "   > " . $amount . "x " . $hardware->getName() . PHP_EOL;
        }


        echo PHP_EOL;
        echo "   - Value: " . $transporter->getCurrentValue() . PHP_EOL;
        echo "   - Unused capacity: " . $transporter->getCurrentCapacity() . "g" . PHP_EOL;

        echo PHP_EOL . PHP_EOL ;

    }


    $totalValue = 0;
    foreach ($transporters as $transporter) {
        $totalValue += $transporter->getCurrentValue();
    }

    echo "--------------------------------------------------------" . PHP_EOL;
    echo " Total value: " . $totalValue . PHP_EOL;
    echo "--------------------------------------------------------" . PHP_EOL;

?>