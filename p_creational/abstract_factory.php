<?php

use JetBrains\PhpStorm\Pure;

$config = 'alpha';

switch ($config) {
    case 'alpha':
        $model = new Gamefield(new ProtosArmyFactory());
        break;
    case 'beta':
        $model = new Gamefield(new TerranArmyFactory());
        break;
}

/** @var $model Gamefield */
$model->getArmy(); // client code based on abstract factory




/** code... */

class Gamefield {
    // ABSTRACT FACTORY instance (injection)
    public function __construct(protected ArmyFactory $factory) {
    }

    // ABSTRACT FACTORY usage
    public function getArmy(): array {
        return [
            $this->factory->createTrooper(),
            $this->factory->createTrooper(),
            $this->factory->createTank(),
        ];
    }
}

// ABSTRACT FACTORY
interface ArmyFactory {
    public function createTrooper(): Trooper;
    public function createTank(): Tank;
}

// ABSTRACT FACTORY realization
class ProtosArmyFactory implements ArmyFactory {
    public function createTrooper(): ProtosTrooper {
        return new ProtosTrooper();
    }
    public function createTank(): ProtosTank {
        return new ProtosTank();
    }
}

// ABSTRACT FACTORY realization
class TerranArmyFactory implements ArmyFactory {
    public function createTrooper(): TerranTrooper {
        return new TerranTrooper();
    }
    public function createTank(): TerranTank {
        return new TerranTank();
    }
}




interface Tank {
    public function isEnemyReachable(int $enemyRange): bool;
}

class ProtosTank implements Tank {
    protected int $range = 16;

    public function isEnemyReachable(int $enemyRange): bool {
        return $enemyRange <= $this->range;
    }
}

class TerranTank implements Tank {
    protected int $range = 18;

    public function isEnemyReachable(int $enemyRange): bool {
        return $enemyRange <= $this->range;
    }
}

interface Trooper {
    public function fireAtWill(int $enemyRange): int;
}

class ProtosTrooper implements Trooper {
    protected int $range = 1;
    protected int $firePower = 22;

    public function fireAtWill(int $enemyRange): int {
        if ($enemyRange <= $this->range) {
            return $this->firePower;
        }
        return 0;
    }
}

class TerranTrooper implements Trooper {
    protected int $range = 12;
    protected int $firePower = 15;

    public function fireAtWill(int $enemyRange): int {
        if ($enemyRange <= $this->range - 2) {
            return $this->firePower;
        }
        else if ($enemyRange <= $this->range) {
            return (int)($this->firePower / 2);
        }
        return 0;
    }
}