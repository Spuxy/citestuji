<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurLengthDeterminatorTest extends TestCase {

    /**
     * @dataProvider getSpecLengthTest
     *
     * @param string $spec
     * @param int $minExpectedSize
     * @param int $maxExpectedSize
     * @return void
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize){
        $det = new DinosaurLengthDeterminator();
        $actualSize = $det->getLengthFromSpecification($spec);
        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertLessThanOrEqual($maxExpectedSize, $actualSize);
    }

    public function getSpecLengthTest() {
        return [
            ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE -1],
//            ['give me all the cookies !!', 0, Dinosaur::LARGE - 1],
            ['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE-1],
            ['huge dinosaur', Dinosaur::HUGE, 100],
            ['huge dino', Dinosaur::HUGE, 100],
            ['huge', Dinosaur::HUGE, 100],
            ['OMG', Dinosaur::HUGE, 100],
            ['😱', Dinosaur::HUGE, 100],
        ];
    }
}