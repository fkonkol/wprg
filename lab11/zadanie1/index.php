<?php

class NoweAuto {
    public function __construct(
        protected string $model, 
        protected float $price, 
        protected float $eurPLN
    ) {}

    public function obliczCene()
    {
        return $this->price * $this->eurPLN;
    }
}

class AutoZDodatkami extends NoweAuto
{
    public function __construct(
        string $model,
        float $price,
        float $eurPLN,
        protected float $alarm,
        protected float $radio,
        protected float $klimatyzacja,
    ) {
        parent::__construct($model, $price, $eurPLN);
    }

    public function obliczCene()
    {
        $cenaPodstawowa = parent::obliczCene();
        $cenaDodatkow = ($this->alarm + $this->radio + $this->klimatyzacja) * $this->eurPLN;
        return $cenaPodstawowa + $cenaDodatkow;
    }
}

class Ubezpieczenie extends AutoZDodatkami
{
    public function __construct(
        string $model,
        float $price,
        float $eurPLN,
        float $alarm,
        float $radio,
        float $klimatyzacja,
        protected float $procentowaWartoscUbezpieczenia,
        protected int $liczbaLatPosiadania,
    ) {
        parent::__construct($model, $price, $eurPLN, $alarm, $radio, $klimatyzacja);
    }

    public function obliczCene()
    {
        $znizka = max(0, (100 - $this->liczbaLatPosiadania) / 100);
        return parent::obliczCene() * $this->procentowaWartoscUbezpieczenia * $znizka;
    }
}

$u = new Ubezpieczenie(
    "Audi A6 C8",
    price: 54000,
    eurPLN: 4.4,
    alarm: 1000,
    radio: 1000,
    klimatyzacja: 1000,
    procentowaWartoscUbezpieczenia: 0.06,
    liczbaLatPosiadania: 2,
);

echo $u->obliczCene();
