<?php
//Re-deklare the variables for better usage
    /** @var array  $transporter */
    $transporters = $transporters ?? [];
    /** @var array  $hardware */
    $hardware = $hardware ?? [];

?>



<h1>Hardware</h1>
<table border="1">

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


    <?php /** @var src\Hardware $item */?>
    <?php foreach($hardware as $item): ?>
        <?php $count = (isset($count)) ? $count+1 : 1; ?>

        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $item->getName(); ?></td>
            <td><?php echo $item->getWeight(); ?></td>
            <td><?php echo $item->getValue(); ?></td>
            <td><?php echo $item->getEfficiency(); ?></td>
            <td><?php echo $item->getRequirement(); ?></td>
        </tr>

    <?php endforeach ?>

</table>



<h1>Transporters</h1>

<table border="1">

    <thead>
        <tr>
            <td>Truck ID</td>
            <td>Maximales Gewicht (in kg)</td>
            <td>Fahrergewicht (in kg)</td>
            <td>Verbleibendes Lastgewicht (in kg)</td>
            <td>Gesamtwert</td>
            <td>Ladung</td>
        </tr>
    </thead>


    <?php /** @var src\Transporter $transporter */?>
    <?php foreach($transporters as $transporter): ?>
    <?php $count = (isset($count)) ? $count+1 : 1; ?>

        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo g2kg($transporter::MAX_CAPACITY); ?></td>
            <td><?php echo g2kg($transporter->getDriverWeight()); ?></td>
            <td><?php echo g2kg($transporter->getCurrentCapacity()); ?></td>
            <td><?php echo $transporter->getCurrentValue(); ?></td>
            <td>
                <ul>
                    <?php foreach($transporter->getCurrentCargo() as $cargo): ?>
                    <?php $hardware = $cargo[0]; /** @var src\Hardware $hardware */
                          $amount = $cargo[1];   /** @var int $amount */ ?>

                        <li>
                            <?php echo $amount; ?>x <?php echo $hardware->getName(); ?>
                        </li>

                    <?php endforeach ?>
                </ul>
            </td>

        </tr>

    <?php endforeach ?>

</table>

Gesamtwert: <?php echo getTotalValue($transporters); ?>


<?php
function g2kg(int $g) {
    return $g/1000;
}
?>