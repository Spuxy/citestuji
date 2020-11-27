<?php


namespace Tests\AppBundle\Factory;


use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinasaurFactory;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactoryTest extends TestCase {


	/**
	 * @var DinasaurFactory
	 */
	private $factory;

	private $lengthDeterminator;

	protected function setUp() : void {
		$this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
		$this->factory = new DinasaurFactory($this->lengthDeterminator);
	}

	public function testItGrowsAVelociraptor() {

		$din = $this->factory->growVelociraptor(5);
		$this->assertInstanceOf(Dinosaur::class, $din);
		$this->assertIsString('string', $din->getGenus());
		$this->assertSame('Velociraptor', $din->getGenus());
		$this->assertSame(5, $din->getLength());
	}


	/**
	 * @dataProvider getSpecificationTests()
	 * @param string $spec
	 * @param bool   $expectedIsLarge
	 * @param bool   $idk
	 */
	public function testItGrowsADinosaurFromASpecifiation(string $spec, bool $idk) {
		$this->lengthDeterminator->expects($this->once())->method('getLengthFromSpecification')->with($spec)->willReturn(20);

		$din = $this->factory->growFromSpecification($spec);

		$this->assertSame($idk,$din->isCarnivorous());
		$this->assertSame(20, $din->getLength());
	}

	public function getSpecificationTests() {
		return [
			['large carnivorous dinosaur', true],
			['give me all the cookies!!', false],
			['large hebivore', false],
		];
	}
}