<?php


namespace Tests\AppBundle\Service;


use PHPUnit\Framework\TestCase;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Factory\DinasaurFactory;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\hello;

class EnclosureBuilderServiceTest extends TestCase {

	public function testItBuildsAndPersistsEnclosure() {
		$em = $this->createMock(EntityManagerInterface::class);
		$em->expects($this->once())->method('persist')->with($this->isInstanceOf(Enclosure::class));
		$em->expects($this->atLeastOnce())->method('flush');
		$factory = $this->createMock( DinasaurFactory::class);
		$factory->expects($this->exactly(2))->method('growFromSpecification')->with($this->isType('string'));

		$picovina = $this->createMock(hello::class);
		$picovina->expects($this->once())->method('say')->willReturn('world');

		$builder = new EnclosureBuilderService($em, $factory, $picovina);
		$enclosure = $builder->buildEnclosure(1, 2);
		$this->assertCount(1, $enclosure->getSecurities());
		$this->assertCount(2, $enclosure->getDinosaurus());
		$this->assertSame('world', $builder->hello());
	}

}