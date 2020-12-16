<?php

require_once("src/Hardware.php");
require_once("src/Transporter.php");

use src\Hardware;
use src\Transporter;




/*
 * Define Values
 */

/** @var array $hardware */
$hardware = [
    'Notebook Büro 13"' => new Hardware('Notebook Büro 13"', 205, 2451, 40),
    'Notebook Büro 14"' => new Hardware('Notebook Büro 14"', 420, 2978, 35),
    'Notebook outdoor' => new Hardware('Notebook outdoor', 450, 3625, 80),
    'Mobiltelefon Büro' => new Hardware('Mobiltelefon Büro', 60, 717, 30),
    'Mobiltelefon outdoor' => new Hardware('Mobiltelefon outdoor', 157, 988, 60),
    'Mobiltelefon Heavy Duty' => new Hardware('Mobiltelefon Heavy Duty', 220, 1220, 65),
    'Tablet Büro klein' => new Hardware('Tablet Büro klein', 620, 1405, 40),
    'Tablet Büro groß' => new Hardware('Tablet Büro groß', 250, 1455, 40),
    'Tablet outdoor klein' => new Hardware('Tablet outdoor klein', 540, 1690, 45),
    'Tablet outdoor groß' => new Hardware('Tablet outdoor groß', 370, 1980, 68),
];

/** @var array $transporters */
$transporters = [
    new Transporter(72400),
    new Transporter(85700),
];





/*
 * Computation
 */
include("scripts/compute.php");
doAlgorythmStuff($transporters, $hardware);






/*
 * Scheme for the output
 */
if(defined('STDIN')) {
    //the file is called from the cli
    include("scripts/output-cli.php");
}
else {
    //the file is called from a browser
    include("scripts/output-browser.php");
}
