<?php

$dir = new CastleArchitectDirector();

$builder = new ZombieCastleBuilder();
$dir->createEpicCastle($builder);
$dir->upgradeEpicCastle($builder); // client code based on builder

$coolCastle = $builder->getResult();

$builder = new UnicornCastleBuilder();
$dir->createEpicCastle($builder);

$fooCastle = $builder->getResult();




/** code... */

class CastleArchitectDirector {
    public function createEpicCastle(CastleBuilder $builder): void {
        $builder->makeGate()
            ->makeWall()
            ->makeWall()
            ->makeTower()
            ->makeWall()
            ->makeWall()
            ->makeMoat();
    }

    public function upgradeEpicCastle(CastleBuilder $builder): void {
        $builder->makeGate()
            ->makeWall()
            ->makeWall();
    }
}

interface CastleBuilder {
    public function makeGate(): CastleBuilder;
    public function makeWall(): CastleBuilder;
    public function makeTower(): CastleBuilder;
    public function makeMoat(): CastleBuilder;

    public function getResult(): string;
}

abstract class AbstractCastle implements CastleBuilder {
    protected string $castle = '';

    public function getResult(): string {
        return $this->castle;
    }
}

class UnicornCastleBuilder extends AbstractCastle implements CastleBuilder {
    public function makeGate(): UnicornCastleBuilder {
        $this->castle .= '{   }';
        return $this;
    }
    public function makeWall(): UnicornCastleBuilder {
        $this->castle .= '##';
        return $this;
    }
    public function makeTower(): UnicornCastleBuilder {
        $this->castle .= 'I';
        return $this;
    }
    public function makeMoat(): UnicornCastleBuilder {
        $this->castle .= '__';
        return $this;
    }
}

class ZombieCastleBuilder extends AbstractCastle implements CastleBuilder {
    public function makeGate(): ZombieCastleBuilder {
        $this->castle .= '[   ]';
        return $this;
    }
    public function makeWall(): ZombieCastleBuilder {
        $this->castle .= '%%';
        return $this;
    }
    public function makeTower(): ZombieCastleBuilder {
        $this->castle .= 'i';
        return $this;
    }
    public function makeMoat(): ZombieCastleBuilder {
        $this->castle .= '..';
        return $this;
    }
}