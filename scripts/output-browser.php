<?php

use src\Hardware;
use src\Transporter;

    //Die Variablen werden neu deklariert, um von der IDE als Referenz genutzt werden zu können
    /** @var array $transporter */
    $transporters = $transporters ?? [];
    /** @var array $hardware */
    $hardware = $hardware ?? [];
?>

<!-- Warnung! -->
<!-- Das folgende HTML Markup ist nicht kommentiert order angemessen strukturiert, da es nicht zum Projekt-Code gehört. -->
<!-- Für eine ernstere und einfachere Ausgabe, bitte die index.php Datei über die Kommandozeile aufrufen -->

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

            table tr:nth-of-type(2n) {
                background: #cccccc;
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


        <div id="result">Gesamt Nutzwert: <?php echo getTotalValue($transporters); ?></div>


        <h1>Transporter</h1>

        <div id="resultTable">
            <div id="animationSpace">
                <span class="car"><span class="car-screen"></span></span>
                <span class="car"><span class="car-screen"></span></span>
            </div>
            <table>

                <thead>
                <tr>
                    <td>Transporter ID</td>
                    <td>Maximal-Gewicht (in g)</td>
                    <td>Fahrer-Gewicht (in g)</td>
                    <td>Ungenutzes Gewicht (in g)</td>
                    <td>Nutzwert</td>
                    <td>Ladung</td>
                </tr>
                </thead>
                <tbody>

                <?php $counter = 0; ?>
                <?php /** @var Transporter $transporter */ ?>
                <?php foreach ($transporters as $transporter): ?>

                    <tr>
                        <td><?php echo ++$counter; ?></td>
                        <td><?php echo $transporter::MAX_CAPACITY; ?></td>
                        <td><?php echo $transporter->getDriverWeight(); ?></td>
                        <td><?php echo $transporter->getCurrentCapacity(); ?></td>
                        <td><?php echo $transporter->getCurrentValue(); ?></td>
                        <td>
                            <ul>
                                <?php foreach ($transporter->getCurrentCargo() as $cargo): ?>
                                    <?php
                                        /** @var Hardware $cargoItem */
                                        $cargoItem = $cargo[0];
                                        /** @var int $amount */
                                        $amount = $cargo[1];
                                    ?>

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


        <h1>Zusätzliche Info: Hardware (End-Zustand)</h1>

        <table>

            <thead>
            <tr>
                <td>Hardware ID</td>
                <td>Name</td>
                <td>Gewicht (in g)</td>
                <td>Nutz-Wert</td>
                <td>Effizienz-Wert</td>
                <td>Im Lager verbleibend</td>
            </tr>
            </thead>

            <tbody>
            <?php $counter = 0; ?>
            <?php /** @var Hardware $item */ ?>
            <?php foreach ($hardware as $item): ?>

                <tr>
                    <td><?php echo ++$counter; ?></td>
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
