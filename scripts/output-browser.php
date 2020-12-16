<?php

use src\Hardware;
use src\Transporter;

//Re-deklare the variables for better usage
    /** @var array  $transporter */
    $transporters = $transporters ?? [];
    /** @var array  $hardware */
    $hardware = $hardware ?? [];

?>


<html lang="de">
    <head>
        <style type="text/css">
            * {
                box-sizing: border-box;
                font-family: Verdana, Arial, "sans-serif";
            }

            #result {
                width: 100%;
                text-align: center;
                font-size: 40px;
                font-weight: 700;
                text-decoration: underline;
            }

            table {
                border-collapse: collapse;
                border: 1px solid #000;
                width: 100%;
            }
            table tr {
                border: 1px solid #000;
            }
            table tr td {
                border: 1px solid #000;
                padding: 10px;
                text-align: center;
            }
            table tr td:last-of-type {
                text-align: left;
            }
            table thead tr td {
                background: #00e2a2;
            }
            table thead tr td:last-of-type {
                text-align: center;
            }


            #resultTable {
                margin-top: 50px;
                position: relative;
            }

            @keyframes carDrive {
                0% {
                    left: 0;
                    transform: scaleX(1);
                }
                50% {
                    left: calc(100% - 50px);
                    transform: scaleX(1);
                }
                51% {
                    transform: scaleX(-1);
                }
                100% {
                    left: 0;
                    transform: scaleX(-1);
                }
            }
            #animationSpace {
                position: absolute;
                top: 0;
                height: 50px;
                width: 100%;
                transform: translateY(-100%);
            }
            #animationSpace .car {
                height: 30px;
                width: 50px;
                display: inline-block;
                margin-top: 15px;
                border-radius: 5px 30px 5px 5px;
                position: absolute;
                animation-duration: 10s;
                animation-iteration-count: infinite;
                animation-name: carDrive;
            }
            #animationSpace .car:before,
            #animationSpace .car:after {
                content: "";
                position: absolute;
                bottom: -6px;
                width: 12px;
                height: 12px;
                background: black;
                border-radius: 50%;
            }
            #animationSpace .car:after {
                right: 0;
            }
            #animationSpace .car {
                background: red;
                left: 0;
            }
            #animationSpace .car:last-of-type {
                background: blue;
                right: 0;
                animation-delay: -4s;
            }
            #animationSpace .car .car-screen {
                position: absolute;
                height: 20px;
                width: 20px;
                background: gray;
                right: 0;
                border-radius: 0 20px 0 0;
            }
        </style>
        <title>BWI-Lösung</title>

    </head>
    <body>


        <div id="result">Total value: <?php echo getTotalValue($transporters); ?></div>


        <h1>Transporters</h1>

        <div id="resultTable">
            <div id="animationSpace">
                <span class="car"><span class="car-screen"></span></span>
                <span class="car"><span class="car-screen"></span></span>
            </div>
            <table>

                <thead>
                    <tr>
                        <td>Truck ID</td>
                        <td>Maximum weight (in g)</td>
                        <td>Driver weight (in g)</td>
                        <td>Unused weight (in g)</td>
                        <td>Value</td>
                        <td>Cargo</td>
                    </tr>
                </thead>
                <tbody>

                    <?php /** @var Transporter $transporter */?>
                    <?php foreach($transporters as $transporter): ?>
                        <?php $count = (isset($count)) ? $count+1 : 1; ?>

                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $transporter::MAX_CAPACITY; ?></td>
                            <td><?php echo $transporter->getDriverWeight(); ?></td>
                            <td><?php echo $transporter->getCurrentCapacity(); ?></td>
                            <td><?php echo $transporter->getCurrentValue(); ?></td>
                            <td>
                                <ul>
                                    <?php foreach($transporter->getCurrentCargo() as $cargo): ?>
                                        <?php $cargoItem = $cargo[0]; /** @var Hardware $cargoItem */
                                        $amount = $cargo[1];   /** @var int $amount */ ?>

                                        <li>
                                            <?php echo $amount; ?>x <?php echo $cargoItem->getName(); ?>
                                        </li>

                                    <?php endforeach ?>
                                </ul>
                            </td>

                        </tr>

                    <?php endforeach ?>

                </tbody>
            </table>
        </div>



        <h1>Hardware</h1>

        <table>

            <thead>
            <tr>
                <td>Hardware ID</td>
                <td>Name</td>
                <td>Gewicht (in g)</td>
                <td>Nutzwert</td>
                <td>Effizienz-Wert</td>
                <td>Verbleibend</td>
            </tr>
            </thead>

            <tbody>
                <?php /** @var Hardware $item */?>
                <?php $count = 0; ?>
                <?php foreach($hardware as $item): ?>
                    <?php $count++; ?>

                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $item->getName(); ?></td>
                        <td><?php echo $item->getWeight(); ?></td>
                        <td><?php echo $item->getValue(); ?></td>
                        <td><?php echo $item->getEfficiency(); ?></td>
                        <td><?php echo $item->getRequirement(); ?></td>
                    </tr>

                <?php endforeach ?>

            </tbody>

        </table>



    </body>
</html>
