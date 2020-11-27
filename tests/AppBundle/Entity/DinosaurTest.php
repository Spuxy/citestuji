<?php


namespace Tests\AppBundle\Entity;


use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Dinosaur;

class DinosaurTest extends TestCase {

	public function testSettingLength() {
		$dinosaur = new Dinosaur();
		$this->assertSame(0, $dinosaur->getLength());
		$dinosaur->setLength(9);
		$this->assertSame(9, $dinosaur->getLength());
	}

	public function testDinosaurHasNotShrunk() {
		$din = new Dinosaur();
		$din->setLength(13);
		$this->assertGreaterThan(12, $din->getLength(),'wdym');
	}

	public function testReturnFullSpecOfDinosaur() {
		$dinasaur = new Dinosaur();
		$this->assertSame("The unknown non-carnivorous dinosaur is 0 meters long", $dinasaur->getSpecification());
	}

	public function testReturnsFullSpecForTyrannosaurus() {
		$din = new Dinosaur('Tyrannosaurus', true);
		$din->setLength(12);
		$this->assertSame("The Tyrannosaurus carnivorous dinosaur is 12 meters long", $din->getSpecification());
	}
}