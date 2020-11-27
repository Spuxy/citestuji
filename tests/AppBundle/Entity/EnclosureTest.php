<?php


namespace Tests\AppBundle\Entity;


use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Enclosure as En;
use AppBundle\Entity\Dinosaur;
use AppBundle\Exception\NotABuffetException;
use AppBundle\Exception\DinosaurusAreRunningRampantException;

class EnclosureTest extends TestCase {

	public function testItHasNoDinosaursByDef() {
		$enclosure = new En();
		$this->assertCount(0, $enclosure->getDinosaurus());
	}

	public function testItAddDinosaurus() {
		$enclosure = new En(true);
		$enclosure->addDinosaurus(new Dinosaur());
		$enclosure->addDinosaurus(new Dinosaur());
		$this->assertCount(2, $enclosure->getDinosaurus());
	}

	public function testItDoestNotAllowCarnivorousDinosaututsToMixWithHerba() {
		$enclosure = new En(true);
		$enclosure->addDinosaurus(new Dinosaur());
		$this->expectException(NotABuffetException::class);
		$enclosure->addDinosaurus(new Dinosaur('Velociraptor', true));
	}

	/**
	 * @expectedException \AppBundle\Exception\NotABuffetException 
	 * @throws DinosaurusAreRunningRampantException
	 * @throws NotABuffetException
	 */
	public function testItDoestNotAllowCarnivorousDinosaututsToMixWithHerba2() {
		$enclosure = new En(true);
		$enclosure->addDinosaurus(new Dinosaur('Velociraptor', true));
		$enclosure->addDinosaurus(new Dinosaur());
	}

	public function testItDoesNotAllowToAdDinosaursToUnsecureEnclosures() {
		$enclosure = new En();
		$this->expectException(DinosaurusAreRunningRampantException::class);
		$this->expectDeprecationMessage("wtf");
		$enclosure->addDinosaurus(new Dinosaur());
	}
}