<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dinosaurs")
 */
class Dinosaur
{
	const HUGE = 30;
	const LARGE = 20;

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enclosure", inversedBy="dinosaurus")
	 */
	private $enclosure;

    private $name;
	private $isCarnivorous;

	public function __construct(string $name = "unknown", bool $isCarnivorous = false) {
		$this->name = $name;
		$this->isCarnivorous = $isCarnivorous;
	}

	public function getLength():int {
		return $this->length;
    }

	public function setLength(int $length):void {
		$this->length = $length;
    }

	public function getSpecification():string {
		return sprintf("The %s %s dinosaur is %d meters long", $this->name, $this->isCarnivorous ? 'carnivorous' : 'non-carnivorous', $this->length);
    }

	public function isCarnivorous():bool {
		return $this->isCarnivorous;
    }

	public function getGenus():string {
		return $this->name;
    }
}
