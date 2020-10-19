<?php

namespace App\Tests\Unit;

use App\Entity\Sejour;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Date;

class SejourTest extends TestCase
{
    /**
     * @var Sejour
     */
    private $sejour;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sejour = new Sejour();
    }

    public function testGetDescription(): void
    {
        $value = 'séjour dans un pays de reve sans virus';
        $response = $this->sejour->setDescription($value);

        self::assertInstanceOf(Sejour::class,$response);
        self::assertEquals($this->sejour->getDescription(),$value);

    }

    public function testGetPrix(): void
    {

        $value = 2000;
        $response = $this->sejour->setPrix($value);

        self::assertInstanceOf(Sejour::class,$response);
        self::assertEquals($this->sejour->getPrix(),$value);
    }

    public function testGetSommeReglee(): void
    {

        $value = 500;
        $response = $this->sejour->setSommeReglee($value);

        self::assertInstanceOf(Sejour::class,$response);
        self::assertEquals($this->sejour->getSommeReglee(),$value);
    }

    public function testGetDateDebut(): void
    {
        $value = new \DateTimeImmutable();
        $response = $this->sejour->setDateDebut($value);

        self::assertInstanceOf(Sejour::class,$response);
        self::assertEquals($this->sejour->getDateDebut(),$value);

    }

    public function testGetDateFin(): void
    {
        $value = new \DateTimeImmutable();
        $response = $this->sejour->setDateFin($value);

        self::assertInstanceOf(Sejour::class,$response);
        self::assertEquals($this->sejour->getDateFin(),$value);

    }
}
