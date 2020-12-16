<?php

require_once("src/Hardware.php");
require_once("src/Transporter.php");


/*
 * Define Values
 */

/** @var array $hardware */
$hardware = [
    new \src\Hardware('Notebook Büro 13"', 205, 2451, 40),
    new \src\Hardware('Notebook Büro 14"', 420, 2978, 35),
    new \src\Hardware('Notebook outdoor', 450, 3625, 80),
    new \src\Hardware('Mobiltelefon Büro', 60, 717, 30),
    new \src\Hardware('Mobiltelefon outdoor', 157, 988, 60),
    new \src\Hardware('Mobiltelefon Heavy Duty', 220, 1220, 65),
    new \src\Hardware('Tablet Büro klein', 620, 1405, 40),
    new \src\Hardware('Tablet Büro groß', 250, 1455, 40),
    new \src\Hardware('Tablet outdoor klein', 540, 1690, 45),
    new \src\Hardware('Tablet outdoor groß', 370, 1980, 68),
];

/** @var array $transporters */
$transporters = [
    new \src\Transporter(72400),
    new \src\Transporter(85700),
];



/*
 * Computation
 */
include("scripts/compute.php");
doAlgorythmStuff($transporters, $hardware);




/*
 * Scheme for the output
 */
sortHardwareByEfficiency($hardware);
include("scripts/output.php");