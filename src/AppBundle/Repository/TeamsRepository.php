<?php

namespace AppBundle\Repository;

use AppBundle\Utils\Util as Util;

/**
 * TeamsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamsRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param string $name The person name searched
     * @param bool $exact Tells if search for an exact match or not
     * @param string $locale The current locale used for language corresponding specific display and search
     * @return array
     */
    public function searchInName($name, $exact = false, $locale = 'en', $exclusionTable = 'none', $exclusionId = 0) {

        $em = $this->getEntityManager();
        $conn = $em->getConnection();

        $qb = $conn->createQueryBuilder();

        $distinct = '';

        if( $exclusionTable === 'person' || $exclusionTable === 'projects' ) {
            $distinct = 'DISTINCT ';
        }

        $params = array('locale' => $locale);

        $qb
            ->select(
                "   $distinct
                    t.id as \"value\",
                    CASE
                      WHEN t.international_cascade = 2 THEN
                        t.international_name
                      WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                        t.international_name
                      ELSE
                        CASE
                          WHEN :locale = 'nl' THEN
                            CASE
                              WHEN t.name_nl IS NULL THEN
                                t.international_name
                              ELSE
                                t.name_nl
                            END
                          WHEN :locale = 'fr' THEN
                            CASE
                              WHEN t.name_fr IS NULL THEN
                                t.international_name
                              ELSE
                                t.name_fr
                            END
                          ELSE
                            CASE
                              WHEN t.name_en IS NULL THEN
                                t.international_name
                              ELSE
                                t.name_en
                            END
                        END
                    END as \"label\",
                 CASE
                   WHEN COALESCE(t.end_date,'2999/01/01'::timestamp) > now() THEN
                     'active'
                   ELSE
                     'inactive'
                 END as \"active\"
                "
            )
            ->from(
                'teams',
                't'
            );

        if ( $exclusionTable === 'projects' ) {
            $qb->where(
                'NOT EXISTS (
                    SELECT 1 
                    FROM teams_projects 
                    WHERE team_ref = t.id 
                      AND project_ref = :project_id 
                      AND start_date IS NULL 
                      AND end_date IS NULL
                 )'
            );
            $params['project_id'] = $exclusionId;
        }
        elseif ( $exclusionTable === 'person' ) {
            $qb->where(
                'NOT EXISTS (
                    SELECT 1 
                    FROM teams_members 
                    WHERE team_ref = t.id 
                      AND person_ref = :person_id 
                      AND start_date IS NULL 
                      AND end_date IS NULL
                 )'
            );
            $params['person_id'] = $exclusionId;
        }

        if ( $exact === true ) {
            $qb->andwhere('
                   CASE 
                       WHEN t.international_cascade = 2 THEN
                         t.international_name
                       WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                         t.international_name
                       ELSE
                         CASE
                           WHEN :locale = \'nl\' THEN
                             CASE
                               WHEN t.name_nl IS NULL THEN
                                 t.international_name
                               ELSE
                                 t.name_nl
                             END
                           WHEN :locale = \'fr\' THEN
                             CASE
                               WHEN t.name_fr IS NULL THEN
                                 t.international_name
                               ELSE
                                 t.name_fr
                             END
                           ELSE
                             CASE
                               WHEN t.name_en IS NULL THEN
                                 t.international_name
                               ELSE
                                 t.name_en
                             END
                         END
                   END ilike :name'
            );

            $params['name'] = $name;
        }
        else {
            foreach (explode(' ', $name) as $key => $term) {

                $term = trim($term);
                if ($term == '') continue;
                $term = Util::unaccent($term);
                $qb->andWhere("
                    translate(
                       CASE 
                           WHEN t.international_cascade = 2 THEN
                             t.international_name
                           WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                             t.international_name
                           ELSE
                             CASE
                               WHEN :locale = 'nl' THEN
                                 CASE
                                   WHEN t.name_nl IS NULL THEN
                                     t.international_name
                                   ELSE
                                     t.name_nl
                                 END
                               WHEN :locale = 'fr' THEN
                                 CASE
                                   WHEN t.name_fr IS NULL THEN
                                     t.international_name
                                   ELSE
                                     t.name_fr
                                 END
                               ELSE
                                 CASE
                                   WHEN t.name_en IS NULL THEN
                                     t.international_name
                                   ELSE
                                     t.name_en
                                 END
                             END
                       END, 'äàáëéèêöôîï','aaaeeeeooii'
                    ) ilike :term$key"
                );
                $params["term$key"] = '%'.$term.'%';
            }
        }

        $qb->setParameters($params)
            ->setMaxResults(300)
            ->orderBy('label,value');

        $query_prepared = $conn->prepare($qb->getSQL());
        $query_prepared->execute($qb->getParameters());

        return $query_prepared->fetchAll();

    }

    /**
     * @param string $locale The locale used to organize the groups of teams retrieved
     * @param string $letter The first letter used to get a list filtered by the team name first letter
     * @return array
     */
    public function groupsByLetters($locale = 'en', $letter = '*', $startFrom = 0) {
        $response = Util::alphaRange();
        $dbResponse = array();

        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        $qb = $conn->createQueryBuilder();
        $params = array('locale' => $locale);

        $qb->select(
            " t.id as \"id\",
              t.international_name as \"internationalName\",
              t.international_name_language as \"internationalNameLanguage\",
              t.international_description as \"internationalDescription\",
              t.international_cascade as \"internationalCascade\",
              t.name_en as \"nameEn\",
              t.description_en as \"descriptionEn\",
              t.name_fr as \"nameFr\",
              t.description_fr as \"descriptionFr\",
              t.name_nl as \"nameNl\",
              t.description_nl as \"descriptionNl\",
              t.start_date as \"startDate\",
              t.end_date as \"endDate\",
              unaccent(regexp_replace(
                  upper(
                    left(
                        CASE
                          WHEN t.international_cascade = 2 THEN
                            t.international_name
                          WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                            t.international_name
                          ELSE
                            CASE
                              WHEN :locale = 'nl' THEN
                                CASE
                                  WHEN t.name_nl IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_nl
                                 END
                              WHEN :locale = 'fr' THEN
                                CASE
                                  WHEN t.name_fr IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_fr
                                END
                              ELSE
                                CASE
                                  WHEN t.name_en IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_en
                                END
                            END
                        END,
                        1
                    )
                  ),
                  E'\\\d',
                  '#' 
              )) as \"firstLetter\",
              CASE
                WHEN t.international_cascade = 2 THEN
                  t.international_name
                WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                  t.international_name
                ELSE
                  CASE
                    WHEN :locale = 'nl' THEN
                      CASE
                        WHEN t.name_nl IS NULL THEN
                          t.international_name
                        ELSE
                          t.name_nl
                       END
                    WHEN :locale = 'fr' THEN
                      CASE
                        WHEN t.name_fr IS NULL THEN
                          t.international_name
                        ELSE
                          t.name_fr
                      END
                    ELSE
                      CASE
                        WHEN t.name_en IS NULL THEN
                          t.international_name
                        ELSE
                          t.name_en
                      END
                  END
              END as \"name\",
              CASE
                WHEN COALESCE(t.end_date,'2999/01/01'::timestamp) > now() THEN
                  'active'
                ELSE
                  'inactive'
              END as \"active\",
              COUNT(id) OVER (PARTITION BY unaccent(regexp_replace(
                  upper(
                    left(
                        CASE
                          WHEN t.international_cascade = 2 THEN
                            t.international_name
                          WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                            t.international_name
                          ELSE
                            CASE
                              WHEN :locale = 'nl' THEN
                                CASE
                                  WHEN t.name_nl IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_nl
                                 END
                              WHEN :locale = 'fr' THEN
                                CASE
                                  WHEN t.name_fr IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_fr
                                END
                              ELSE
                                CASE
                                  WHEN t.name_en IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_en
                                END
                            END
                        END,
                        1
                    )
                  ),
                  E'\\\d',
                  '#' 
              ))) as counting,
              COUNT(id) OVER () as \"totalCounting\"
            "
        )
        ->from(
            'teams',
            't'
        );

        if ( $startFrom !== 0 ) {
            $qb->setFirstResult($startFrom);
        }

        if ( $letter != '*' ) {
            $qb->where(
                "unaccent(regexp_replace(
                  upper(
                    left(
                        CASE
                          WHEN t.international_cascade = 2 THEN
                            t.international_name
                          WHEN t.international_cascade = 1 AND t.international_name_language = :locale THEN
                            t.international_name
                          ELSE
                            CASE
                              WHEN :locale = 'nl' THEN
                                CASE
                                  WHEN t.name_nl IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_nl
                                 END
                              WHEN :locale = 'fr' THEN
                                CASE
                                  WHEN t.name_fr IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_fr
                                END
                              ELSE
                                CASE
                                  WHEN t.name_en IS NULL THEN
                                    t.international_name
                                  ELSE
                                    t.name_en
                                END
                            END
                        END,
                        1
                    )
                  ),
                  E'\\\d',
                  '#' 
              )) = :letter"
            );
            $params['letter']=$letter;
        }

        $qb->setParameters($params)
            ->setMaxResults(500)
            ->orderBy('"firstLetter",name');

        $query_prepared = $conn->prepare($qb->getSQL());
        $query_prepared->execute($qb->getParameters());
        $dbResponse = $query_prepared->fetchAll();

        foreach( $dbResponse as $content ) {
            $response['*']['count'] = $content['totalCounting'];
            $response[$content['firstLetter']]['count']= $content['counting'];
            $response['*']['list'][] = $content;
            $response[$content['firstLetter']]['list'][]= $content;
        }

        $response[$letter]['selected'] = 1;

        return $response;
    }

    /**
     * @return array List of 3000 first found teams in database
     */
    public function listAll() {
        $dq = $this->createQueryBuilder('t')
            ->select('t.id')
            ->addSelect('t.international_name')
            ->addSelect('t.international_description')
            ->addSelect('t.name_en')
            ->addSelect('t.description_en')
            ->addSelect('t.name_nl')
            ->addSelect('t.description_nl')
            ->addSelect('t.description_nl')
            ->addSelect('t.name_fr')
            ->addSelect('t.description_fr')
            ->addSelect('t.international_name_language')
            ->addSelect('case when t.end_date is null then \'active\' when t.end_date >= CURRENT_TIMESTAMP() then \'active\' else \'inactive\' end as active')
            ->orderBy('t.international_name')
            ->setMaxResults(3000)
            ->getQuery();
        return $dq->getResult();
    }

    /**
     * @param array $ids Array of int ids
     * @param array $relatedFilters array describing the related items that should serve as filter
     * @return array $response an array of team entries found
     */
    public function listByIds(Array $ids, Array $relatedFilters = array()) {
        $response = array();
        return $response;
    }

    /**
     * @param array $ids Array of begin or whole international names
     * @param array $relatedFilters array describing the related items that should serve as filter
     * @return array $response an array of team entries found
     */
    public function listByIntNames(Array $names, Array $relatedFilters = array()) {
        $response = array();
        return $response;
    }
}
