<?php


namespace src;


class Transporter
{
    /** @var int  */
    const MAX_CAPACITY = 1100000;


    /** @var int  */
    private $driverWeight = 0;
    /** @var array  */
    private $cargo = [];




    /**
     * Transporter Konstruktor.
     * @param int $driverWeight
     */
    public function __construct(int $driverWeight)
    {
        $this->driverWeight = $driverWeight;
    }





    /*
    * ##################################################
    * #             Klassen-Methoden                   #
    * ##################################################
    */




    /**
     * Fügt die $hardware $amount mal zum Transporter hinzu. Gibt zurück, ob die Hardware aufgeladen werden konnte
     *
     * @param Hardware $hardware
     * @param int $amount
     * @return bool
     */
    public function addHardware(Hardware &$hardware, int $amount) : bool {

        $newWeight = $hardware->getWeight() * $amount;


        if($this->getCurrentCapacity() < $newWeight) {
            //es gibt nicht genug Platz für die neue Hardware
            return false;
        }
        else {
            //es gibt genug Platz für die neue Hardware

            if(isset($this->cargo[$hardware->getName()])) {
                //Die Hardware ist bereits geladen. Die neue Anzahl wird auf die bestehende addiert
                $this->cargo[$hardware->getName()][1] += $amount;
            }
            else {
                //Es wird ein neuer Eintrag für die Hardware im Array angelegt
                $this->cargo[$hardware->getName()] = [$hardware, $amount];
            }

            //Die hinzugefügt Hardware wird von der benötigten Zahl abgezogen
            $hardware->removeFromRequirement($amount);

            return true;
        }
    }


    /**
     * Entfernt $amount Teile von $hardware aus dem Transporter. Gibt zurück, ob die Hardware entfernt werden konnte
     *
     * @param Hardware $hardware
     * @param int $amount
     * @return bool
     */
    public function removeHardware(Hardware &$hardware, $amount = 1) : bool {

        //wenn die Hardware ausreichend geladen ist, wird die gegebene Anzahl entfernt
        if(isset($this->cargo[$hardware->getName()]) && $this->cargo[$hardware->getName()][1] >= $amount) {


            $this->cargo[$hardware->getName()][1] -= $amount;

            //Wenn kein Teil dieser Hardware übrig bleibt, wird der Eintrag aus dem Array entfernt
            if($this->cargo[$hardware->getName()][1] <= 0) {
                unset($this->cargo[$hardware->getName()]);
            }

            //Die entfernte Anzahl wird wieder zu der benötigten Zahl addiert
            $hardware->addToRequirement($amount);

            return true;
        }
        else {
            return false;
        }

    }









    /*
     * ##################################################
     * #             Getter-Methoden                    #
     * ##################################################
     */





    /**
     * Gibt die aktuelle Kapazität des Transporters zurück, die noch mit Hardware gefüllt werden kann
     *
     * @return int
     */
    public function getCurrentCapacity() : int {
        $currentLoad = 0;

        foreach($this->cargo as $cargo) {
            /** @var Hardware $hardware */
            $hardware = $cargo[0];
            /** @var int $amount */
            $amount = $cargo[1];

            $currentLoad += $hardware->getWeight() * $amount;
        }

        return (self::MAX_CAPACITY - $this->driverWeight - $currentLoad);
    }




    /**
     * Summiert und gibt den Gesamt-Nutzwert der aktuellen Ladung zurück
     *
     * @return int
     */
    public function getCurrentValue() : int {
        $totalValue = 0;

        foreach($this->cargo as $cargo) {
            /** @var Hardware $hardware */
            $hardware = $cargo[0];
            /** @var int $amount */
            $amount = $cargo[1];

            $totalValue += $hardware->getValue() * $amount;
        }

        return $totalValue;
    }




    /**
     * Gibt die aktuelle Ladung zurück
     *
     * @return array
     */
    public function getCurrentCargo() : array{
        return $this->cargo;
    }




    /**
     * Gibt die aktuelle Ladung zurück, allerdings ohne Informationen bezüglich der Menge der Ladung
     *
     * @return array
     */
    public function getCurrentCargoRaw() : array {
        $hardware = [];

        foreach($this->cargo as $cargo) {
            $hardware[] = $cargo[0];
        }

        return $hardware;
    }




    /**
     * @return int
     */
    public function getDriverWeight() {
        return $this->driverWeight;
    }


}