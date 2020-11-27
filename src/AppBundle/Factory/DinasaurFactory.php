<?php


namespace AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinasaurFactory {

	private $dinosaurService;
	
	public function __construct(DinosaurLengthDeterminator $dinosaurLengthDeterminator){
		$this->dinosaurService = $dinosaurLengthDeterminator;	
	}

	public function growVelociraptor(int $length): Dinosaur {
		return $this->createDinosaur('Velociraptor', true, $length);
	}

	public function createDinosaur(string $name, bool $isCarnivorous, int $length) {
		$din = new Dinosaur($name, $isCarnivorous);
		$din->setLength($length);
		return $din;
	}


	public function growFromSpecification(string $specification):Dinosaur {
		$codeName = 'InG-'.random_int(1,99999);
		$length = random_int(1,19);
		$isCarnivorous = false;

		$length = $this->dinosaurService->getLengthFromSpecification($specification);
//		$length = 0;
		if (stripos($specification, 'carnivorous')!==false) {
			$isCarnivorous = true;
		}
		$din = $this->createDinosaur($codeName, $isCarnivorous, $length);
		return $din;
	}
}