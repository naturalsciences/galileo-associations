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

    const PROJECTS_NAMES = [
        'RemSEM',
        'Antabif',
        'Ibisca',
        'OneGeology',
        'BizTalk',
        'Mammals of Antarctic',
        'Gebouw kalkstenen',
        'Monilog',
        'Paloscreen',
        'PIA',
        'PapouFlies',
        'Key Holes',
        'Spy Caves',
        'NaturaLogs',
        'Species.be',
        'DaRWIN',
        'Sea sides',
        'Rock your Bed',
        'Tree Horses',
        'WeedIT'
    ];

    const ORGANIGRAM = [
        [
            'en' => 'General Management',
            'fr' => 'Direction Générale',
            'nl' => 'Algemene Directie',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Directorate Public Services',
            'fr' => 'Direction Opérationnelle Publics',
            'nl' => 'Operationele Directie Publiek',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Directorate Support Services',
            'fr' => 'Direction des Services d’appui',
            'nl' => 'Directie Ondersteuningsdiensten',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Directorate Natural Environment',
            'fr' => 'Direction Opérationnelle Milieux Naturels',
            'nl' => 'Operationele Directie Natuurlijk Milieu',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Directorate Taxonomy and Phylogeny',
            'fr' => 'Direction Opérationnelle Taxonomie et Phylogénie',
            'nl' => 'Operationele Directie Taxonomie en Fylogenie',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Directorate Earth and History of life',
            'fr' => 'Direction Opérationnelle Terre et Histoire de la Vie',
            'nl' => 'Operationele Directie Aarde en Geschiedenis van het Leven',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Scientific Heritage Service',
            'fr' => 'Service Scientifique du Patrimoine',
            'nl' => 'Wetenschappelijke dienst voor het Patrimonium',
            'parent_ref_key' => null
        ],
        [
            'en' => 'Geological Survey of Belgium',
            'fr' => 'Service géologique de Belgique',
            'nl' => 'Belgische Geologische Dienst',
            'parent_ref_key' => 6
        ],
        [
            'en' => 'Entomology',
            'fr' => 'Entomologie',
            'nl' => 'Entomologie',
            'parent_ref_key' => 5
        ],
        [
            'en' => 'Library',
            'fr' => 'Bibliothèque',
            'nl' => 'Bibliotheek',
            'parent_ref_key' => 2
        ],
        [
            'en' => 'Invertebrates',
            'fr' => 'Invertébrés',
            'nl' => 'Invertebraten',
            'parent_ref_key' => 5
        ],
        [
            'en' => 'Palaeobiosphere Evolution',
            'fr' => 'Evolution de la Paléobiosphère',
            'nl' => 'Evolutie van de Paleobiosfeer',
            'parent_ref_key' => 6
        ],
        [
            'en' => 'Technical and logistics services',
            'fr' => 'Services Techniques et Logistiques',
            'nl' => 'Technische en Logistieke Diensten',
            'parent_ref_key' => 3
        ],
        [
            'en' => 'ICT & multimedia',
            'fr' => 'ICT & multimedia',
            'nl' => 'ICT & multimedia',
            'parent_ref_key' => 3
        ],
        [
            'en' => 'ATECO - Aquatic & Terrestrial Ecology',
            'fr' => 'ATECO - Ecologie Aquatique et Terrestre',
            'nl' => 'ATECO - Aquatische en Terrestrische Ecologie',
            'parent_ref_key' =>  4
        ],
        [
            'en' => 'ECOCHEM - Ecosystems Physico-Chemistry',
            'fr' => 'ECOCHEM - Physico-chimie des Ecosystèmes',
            'nl' => 'ECOCHEM - Fysico-Chemie van Ecosystemen',
            'parent_ref_key' => 4
        ],
        [
            'en' => 'ECODAM - Ecosystems data processing and modelling',
            'fr' => 'ECODAM - Traitement des données et modélisation des écosystèmes',
            'nl' => 'ECODAM - Dataverwerking en modellering van ecosystemen',
            'parent_ref_key' => 4
        ],
        [
            'en' => 'BEDIC - Biodiversity & Ecosystems Data & Information centre',
            'fr' => 'BEDIC - Centre de données et d’informations pour la biodiversité et les écosystèmes',
            'nl' => 'BEDIC - Data en informatiecentrum voor biodiversiteit en ecosystemen',
            'parent_ref_key' => 4
        ],
        [
            'en' => 'Scientific collections & archives',
            'fr' => 'Collections scientifiques et archives',
            'nl' => 'Wetenschappelijke collecties en archieven',
            'parent_ref_key' => 7
        ],
        [
            'en' => 'Development',
            'fr' => 'Developement',
            'nl' => 'Ontwikkeling',
            'parent_ref_key' => 14
        ],
        [
            'en' => 'System & Helpdesk',
            'fr' => 'Système & Support',
            'nl' => 'System & Support',
            'parent_ref_key' => 14
        ]
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
            $key = $position-1;
        }
        return self::TEAMS_NAMES[$key];
    }

    public function projectName($position = null) {
        if ($position === null) {
            $key = array_rand(self::PROJECTS_NAMES);
        }
        else {
            $key = $position-1;
        }
        return self::PROJECTS_NAMES[$key];
    }

    public function organigramUnitName($language = 'en', $position = null) {
        if ($position === null) {
            $key = array_rand(self::ORGANIGRAM);
        }
        else {
            $key = $position-1;
        }
        return self::ORGANIGRAM[$key][$language];
    }

    public function organigramUnitParent($position = null) {
        if ($position === null) {
            $key = array_rand(self::ORGANIGRAM);
        }
        else {
            $key = $position-1;
        }
        return self::ORGANIGRAM[$key]['parent_ref_key'];
    }

    public function dateAbove($date, $always = 1) {
        $result = null;
        if ( $date instanceof \DateTime && ( $always === 1 || mt_rand(0,1) === 1 ) ) {
            $startDate = $date->getTimestamp();
            $timestamp = mt_rand($startDate, $startDate + 300000);
            $result = new \DateTime();
            $result->setTimestamp($timestamp);
        }
        return $result;
    }
}
