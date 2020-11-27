<?php


namespace Tests\AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Security;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Dinosaur;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase {

	protected function setUp() : void {
		self::bootKernel();

		$this->truncateEntities();
	}

	public function testWTF() {

		/** @var EnclosureBuilderService $builder */
		$builder = self::$kernel->getContainer()->get('test.'.EnclosureBuilderService::class);
		$builder->buildEnclosure();

		/** @var EntityManager $em */
		$em = self::$kernel->getContainer()->get('doctrine')->getManager();

		$count = (int) $em->getRepository(Security::class)->createQueryBuilder('q')->select('COUNT(q.id)')->getQuery()->getSingleScalarResult();
		$this->assertSame(1, $count);
	}
	private function truncateEntities()
	{
		$pur = new ORMPurger($this->getEntityManager());
		$pur->purge();
	}

	public function getEntityManager() {
		return self::$kernel->getContainer()->get('doctrine')->getManager();
	}
}