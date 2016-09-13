<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 12/09/16
 * Time: 17:30
 */

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    const TEAMS_NAMES = [
        'Naturalist of Belgium',
        'Communication',
        'Monitoring',
        'Ocean 11',
        'Tree climbers',
        'Mineralexperts',
        'Geologist of Belgium',
        'ICT & Multimedia',
        'Direction',
        'Finance',
        'Taxonomists',
        'Diggers',
        'Archeologists',
        'Arachnoexperts',
        'Poulpioexperts',
        'Insect Socialist',
        'Librarians',
        'GIS Makers',
        'Plant lovers',
        'Herbalizers'
    ];

    public function load(ObjectManager $manager)
    {
        Fixtures::load(__DIR__.'/fixtures.yml', $manager, ['providers' => [$this] ]);
    }

    public function uid($firstName, $lastName) {
        $uid = substr($firstName,0,1).strtolower($lastName);
        return $uid;
    }

    public function teamName($position = null) {
        if ($position === null) {
            $key = array_rand(self::TEAMS_NAMES);
        }
        else {
            $key = $position;
        }
        return self::TEAMS_NAMES[$key];
    }
}
