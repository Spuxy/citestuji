<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Exception\NotABuffetException;
use AppBundle\Exception\DinosaurusAreRunningRampantException;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/** @var Collection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
	 */
	private $dinosaurs;

	/**
	 * @var Collection|Security[]
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Security", mappedBy="enclosure", cascade={"persist"})
	 */
	private $securities;

	public function __construct(bool $basicSecurity = false) {
		$this->securities = new ArrayCollection();
		$this->dinosaurs = new ArrayCollection();

		if ($basicSecurity) {
			$this->addSecurity( new Security( 'Fence', true, $this ) );
		}

	}

	public function getDinosaurus(): Collection {
		return $this->dinosaurs;
	}

	public function addDinosaurus(Dinosaur $dinosaur):void  {
		if (!$this->canAddDin($dinosaur)) {
			throw new NotABuffetException();
		}
		if (!$this->isSecurityActive()) {
			throw new DinosaurusAreRunningRampantException("wtf");
		}
		$this->dinosaurs[] = $dinosaur;
	}

	public function isSecurityActive():bool {
		foreach ($this->securities as $security) {
			if ($security->getIsActive()) {
				return true;
			}
		}
		return false;
	}

	public function canAddDin(Dinosaur $dinosaur):bool {
		return count($this->dinosaurs) === 0 || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
	}

	public function addSecurity(Security $param) {
		$this->securities[] = $param;
	 }

	public function getSecurities(): Collection {
		return $this->securities;
	 }
}