<?php

namespace AppBundle\Repository;

use AppBundle\Utils\Util as Util;

/**
 * ProjectsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectsRepository extends BaseRepository
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

        if( $exclusionTable === 'person' || $exclusionTable === 'teams' ) {
            $distinct = 'DISTINCT ';
        }

        $params = array('locale' => $locale);

        $qb
            ->select(
                "   $distinct
                    p.id as \"value\",
                    CASE
                      WHEN p.international_cascade = 2 THEN
                        p.international_name
                      WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                        p.international_name
                      ELSE
                        CASE
                          WHEN :locale = 'nl' THEN
                            CASE
                              WHEN p.name_nl IS NULL THEN
                                p.international_name
                              ELSE
                                p.name_nl
                            END
                          WHEN :locale = 'fr' THEN
                            CASE
                              WHEN p.name_fr IS NULL THEN
                                p.international_name
                              ELSE
                                p.name_fr
                            END
                          ELSE
                            CASE
                              WHEN p.name_en IS NULL THEN
                                p.international_name
                              ELSE
                                p.name_en
                            END
                        END
                    END as \"label\",
                 CASE
                   WHEN COALESCE(p.end_date,'2999/01/01'::timestamp) > now() THEN
                     'active'
                   ELSE
                     'inactive'
                 END as \"active\"
                "
            )
            ->from(
                'projects',
                'p'
            );

        if ( $exclusionTable === 'teams' ) {
            $qb->where(
                'NOT EXISTS (
                    SELECT 1 
                    FROM teams_projects 
                    WHERE project_ref = p.id 
                      AND team_ref = :team_id 
                      AND start_date IS NULL 
                      AND end_date IS NULL
                 )'
            );
            $params['team_id'] = $exclusionId;
        }
        elseif ( $exclusionTable === 'person' ) {
            $qb->where(
                'NOT EXISTS (
                    SELECT 1 
                    FROM projects_members 
                    WHERE project_ref = p.id 
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
                       WHEN p.international_cascade = 2 THEN
                         p.international_name
                       WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                         p.international_name
                       ELSE
                         CASE
                           WHEN :locale = \'nl\' THEN
                             CASE
                               WHEN p.name_nl IS NULL THEN
                                 p.international_name
                               ELSE
                                 p.name_nl
                             END
                           WHEN :locale = \'fr\' THEN
                             CASE
                               WHEN p.name_fr IS NULL THEN
                                 p.international_name
                               ELSE
                                 p.name_fr
                             END
                           ELSE
                             CASE
                               WHEN p.name_en IS NULL THEN
                                 p.international_name
                               ELSE
                                 p.name_en
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
                           WHEN p.international_cascade = 2 THEN
                             p.international_name
                           WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                             p.international_name
                           ELSE
                             CASE
                               WHEN :locale = 'nl' THEN
                                 CASE
                                   WHEN p.name_nl IS NULL THEN
                                     p.international_name
                                   ELSE
                                     p.name_nl
                                 END
                               WHEN :locale = 'fr' THEN
                                 CASE
                                   WHEN p.name_fr IS NULL THEN
                                     p.international_name
                                   ELSE
                                     p.name_fr
                                 END
                               ELSE
                                 CASE
                                   WHEN p.name_en IS NULL THEN
                                     p.international_name
                                   ELSE
                                     p.name_en
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
     * @param int $startFrom The Offset to start from
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
            " p.id as \"id\",
              p.international_name as \"internationalName\",
              p.international_name_language as \"internationalNameLanguage\",
              p.international_description as \"internationalDescription\",
              p.international_cascade as \"internationalCascade\",
              p.name_en as \"nameEn\",
              p.description_en as \"descriptionEn\",
              p.name_fr as \"nameFr\",
              p.description_fr as \"descriptionFr\",
              p.name_nl as \"nameNl\",
              p.description_nl as \"descriptionNl\",
              p.start_date as \"startDate\",
              p.end_date as \"endDate\",
              unaccent(
                  regexp_replace(
                      upper(
                        left(
                            CASE
                              WHEN p.international_cascade = 2 THEN
                                p.international_name
                              WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                                p.international_name
                              ELSE
                                CASE
                                  WHEN :locale = 'nl' THEN
                                    CASE
                                      WHEN p.name_nl IS NULL THEN
                                        p.international_name
                                      ELSE
                                        p.name_nl
                                     END
                                  WHEN :locale = 'fr' THEN
                                    CASE
                                      WHEN p.name_fr IS NULL THEN
                                        p.international_name
                                      ELSE
                                        p.name_fr
                                    END
                                  ELSE
                                    CASE
                                      WHEN p.name_en IS NULL THEN
                                        p.international_name
                                      ELSE
                                        p.name_en
                                    END
                                END
                            END,
                            1
                        )
                      ),
                      E'\\\d',
                      '#' 
                ) 
              ) as \"firstLetter\",
              CASE
                WHEN p.international_cascade = 2 THEN
                  p.international_name
                WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                  p.international_name
                ELSE
                  CASE
                    WHEN :locale = 'nl' THEN
                      CASE
                        WHEN p.name_nl IS NULL THEN
                          p.international_name
                        ELSE
                          p.name_nl
                       END
                    WHEN :locale = 'fr' THEN
                      CASE
                        WHEN p.name_fr IS NULL THEN
                          p.international_name
                        ELSE
                          p.name_fr
                      END
                    ELSE
                      CASE
                        WHEN p.name_en IS NULL THEN
                          p.international_name
                        ELSE
                          p.name_en
                      END
                  END
              END as \"name\",
              CASE
                WHEN COALESCE(p.end_date,'2999/01/01'::timestamp) > now() THEN
                  'active'
                ELSE
                  'inactive'
              END as \"active\",
              COUNT(id) OVER (PARTITION BY unaccent(regexp_replace(
                  upper(
                    left(
                        CASE
                          WHEN p.international_cascade = 2 THEN
                            p.international_name
                          WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                            p.international_name
                          ELSE
                            CASE
                              WHEN :locale = 'nl' THEN
                                CASE
                                  WHEN p.name_nl IS NULL THEN
                                    p.international_name
                                  ELSE
                                    p.name_nl
                                 END
                              WHEN :locale = 'fr' THEN
                                CASE
                                  WHEN p.name_fr IS NULL THEN
                                    p.international_name
                                  ELSE
                                    p.name_fr
                                END
                              ELSE
                                CASE
                                  WHEN p.name_en IS NULL THEN
                                    p.international_name
                                  ELSE
                                    p.name_en
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
            'projects',
            'p'
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
                          WHEN p.international_cascade = 2 THEN
                            p.international_name
                          WHEN p.international_cascade = 1 AND p.international_name_language = :locale THEN
                            p.international_name
                          ELSE
                            CASE
                              WHEN :locale = 'nl' THEN
                                CASE
                                  WHEN p.name_nl IS NULL THEN
                                    p.international_name
                                  ELSE
                                    p.name_nl
                                 END
                              WHEN :locale = 'fr' THEN
                                CASE
                                  WHEN p.name_fr IS NULL THEN
                                    p.international_name
                                  ELSE
                                    p.name_fr
                                END
                              ELSE
                                CASE
                                  WHEN p.name_en IS NULL THEN
                                    p.international_name
                                  ELSE
                                    p.name_en
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
     * @param string $active Tells if the filter on the active projects
     * @param array $relatedFilters List of complementary filter options
     * @param string $withoutDescription Tells if description fields should be removed from output
     * @return array List of 2000 first found projects in database
     */
    public function listAll($active = 'active', Array $relatedFilters = array(), $withoutDescription = 'false') {

        $SQL = $this->extractProjectsTeams('projects', $active, $relatedFilters, $withoutDescription);
        $results = $SQL->fetchAll();
        return $this->purifyResults($results);

    }
}
