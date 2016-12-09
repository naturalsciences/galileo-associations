<?php

namespace AppBundle\Repository;

use AppBundle\Utils\Util as Util;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends BaseRepository
{
    /**
     * @param string $active Tells if we need to filter on active, non active or none "active" parameter
     * @param array $relatedFilters List of complementary filters to apply
     * @return \Doctrine\DBAL\Driver\Statement
     */
    private function extractPeople($active = 'active', Array $relatedFilters = array()) {
        $conn = $this->getEntityManager()->getConnection();
        $qb = $conn->createQueryBuilder();
        $params = array();

        $qb->select('DISTINCT p.id,
                     p.uid as "samaccountname",
                     p.first_name, 
                     p.last_name, 
                     p.email, 
                     case when coalesce(
                                  (select distinct 
                                     max(
                                       case when pe.exit_date is null then TIMESTAMP \'2100-12-31\' else pe.exit_date end
                                     ) 
                                     over 
                                     (partition by pe.person_ref)
                                   from person_entry pe
                                   where pe.person_ref = p.id
                                  ), TIMESTAMP \'2100-12-31\'   
                               ) >= now() 
                     then \'active\' 
                     else \'inactive\' end as "active"'
        )
            ->from(
                'person',
                'p'
            );

        if ( in_array($active, array('active', 'inactive')) ) {
            $qb->andWhere('case when coalesce(
                                  (select distinct 
                                     max(
                                       case when pe.exit_date is null then TIMESTAMP \'2100-12-31\' else pe.exit_date end
                                     ) 
                                     over 
                                     (partition by pe.person_ref)
                                   from person_entry pe
                                   where pe.person_ref = p.id
                                  ), TIMESTAMP \'2100-12-31\'   
                               ) >= now() 
                     then \'active\' 
                     else \'inactive\' end = ?');
            $params[] = $active;
        }

        $this->composeNamingWhere($qb, $params, $relatedFilters, 'p.first_name || \' \' || p.last_name', 'names');

        $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'p.id', 'ids');

        if ( isset($relatedFilters['teams'] ) ) {
            if ( is_array($relatedFilters['teams']) ) {
                if (count($relatedFilters['teams']) > 0) {
                    $qb->innerJoin(
                        'p',
                        'teams_members',
                        'tm',
                        'p.id = tm.person_ref'
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'tm.team_ref', 'teams');
                }
            }
        }

        if ( isset($relatedFilters['projects'] ) ) {
            if ( is_array($relatedFilters['projects']) ) {
                if (count($relatedFilters['projects']) > 0) {
                    $qb->innerJoin(
                        'p',
                        'projects_members',
                        'pm',
                        'p.id = pm.person_ref'
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'pm.project_ref', 'projects');
                }
            }
        }

        if ( isset($relatedFilters['directorates'] ) ) {
            if ( is_array($relatedFilters['directorates']) ) {
                if (count($relatedFilters['directorates']) > 0) {
                    $qb->innerJoin(
                        'p',
                        'working_duty',
                        'wd',
                        'p.id = wd.person_ref'
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'wd.department_ref', 'directorates');
                }
            }
        }

        if ( isset($relatedFilters['services'] ) ) {
            if ( is_array($relatedFilters['services']) ) {
                if (count($relatedFilters['services']) > 0) {
                    $qb->innerJoin(
                        'p',
                        'working_duty',
                        'wd',
                        'p.id = wd.person_ref'
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'wd.department_ref', 'services');
                }
            }
        }

        if ( isset($relatedFilters['uids']) ) {
            if ( is_array($relatedFilters['uids']) ) {
                if ( count($relatedFilters['uids']) > 0 ) {
                    $sqlWhere = '(';
                    foreach( $relatedFilters['uids'] as $value ) {
                        $sqlWhere .= '?,';
                        $params[] = $value;
                    }
                    $sqlWhere = rtrim($sqlWhere, ',');
                    $sqlWhere .= ')';
                    if ($sqlWhere !== '()') {
                        $qb->andWhere('p.uid IN ' . $sqlWhere);
                    }
                }
            }
        }

        $qb
            ->setMaxResults(3000)
            ->orderBy('p.last_name');
        $st = $conn->prepare($qb->getSQL());
        $st->execute($params);
        return $st;
    }

    /**
     * @param string $name The person name searched
     * @param bool $exact Tells if search for an exact match or not
     * @param string $locale
     * @return array
     */
    public function searchInName($name, $exact = false, $locale = 'en', $exclusionTable = 'none', $exclusionId = 0) {
        $conn = $this->getEntityManager()->getConnection();
        $qb = $conn->createQueryBuilder();
        $distinct = '';

        if( $exclusionTable === 'teams' || $exclusionTable === 'projects' ) {
            $distinct = 'DISTINCT ';
        }

        $qb->select(
                    $distinct.'p.id as "value",  
                     p.first_name || \' \' || p.last_name as "label",
                     COALESCE(e.exit_date, \'active\') as "active"'
                   )
            ->from(
                'person',
                'p'
            )
            ->leftJoin(
                'p',
                '(
                    select distinct on (person_ref) 
                            person_ref, 
                            entry_date, 
                            CASE 
                              WHEN coalesce(exit_date,\'01/01/2999\'::timestamp) > now() THEN
                                \'active\' 
                              ELSE 
                                \'inactive\' 
                            END as exit_date
                    from person_entry 
                    order by person_ref,entry_date DESC
                 )',
                'e',
                'e.person_ref=p.id'
            );

        $params = array();

        if ( $exclusionTable === 'teams' ) {
            $qb->where(
                'NOT EXISTS (
                    SELECT 1 
                    FROM teams_members 
                    WHERE person_ref = p.id 
                      AND team_ref = ? 
                      AND start_date IS NULL 
                      AND end_date IS NULL
                 )'
            );
            $params[] = $exclusionId;
        }
        elseif ( $exclusionTable === 'projects' ) {
           $qb->where(
                'NOT EXISTS (
                    SELECT 1 
                    FROM projects_members 
                    WHERE person_ref = p.id 
                      AND project_ref = ? 
                      AND start_date IS NULL 
                      AND end_date IS NULL
                 )'
            );
            $params[] = $exclusionId;
        }

        if( $exact === true ) {
            $qb->andwhere('p.first_name || \' \' || p.last_name ilike ?');
            $params[] = $name;
        }
        else {
            foreach(explode(' ', $name) as $term) {
                $term = trim($term);
                if($term == '') continue;
                $term =  Util::unaccent($term);
                $qb->andwhere("translate(p.first_name || ' ' || p.last_name, 'äàáëéèêöôîï','aaaeeeeooii') ilike ?");
                $params[] = '%'.$term.'%';
            }
        }
        $qb
            ->setMaxResults(300)
            ->orderBy('label,value');
        $st = $conn->prepare($qb->getSQL());
        $st->execute($params);
        return  $st->fetchAll();
    }
    /**
     * @param string $locale The locale used to organize the groups of people retrieved
     * @return array
     */
    public function groupsByLetters($locale = 'en', $letter = '*', $startFrom = 0) {
        $response = Util::alphaRange();

        $conn = $this->getEntityManager()->getConnection();
        $qb = $conn->createQueryBuilder();

        $qb->select(
            "p.id as \"id\",
             p.first_name as \"firstName\",
             p.last_name as \"lastName\",
             p.email as \"email\",
             p.first_name || ' ' || p.last_name as \"name\",
             COALESCE(e.exit_date, 'active') as \"active\",
             unaccent(
                 regexp_replace(
                    upper(
                        left(
                            p.last_name,
                            1
                         )
                      ),
                      E'\\\d',
                      '#' 
                  )
              ) as \"firstLetter\",
              COUNT(p.id) OVER (PARTITION BY unaccent(regexp_replace(
                upper(
                    left(
                        p.last_name,
                        1
                     )
                  ),
                  E'\\\d',
                  '#' 
              ))) as counting,
              COUNT(p.id) OVER () as \"totalCounting\"
            "
        )
        ->from(
            'person',
            'p'
        )
        ->leftJoin(
            'p',
            '(
                select distinct on (person_ref) 
                        person_ref, 
                        entry_date, 
                        CASE 
                          WHEN coalesce(exit_date,\'01/01/2999\'::timestamp) > now() THEN
                            \'active\' 
                          ELSE 
                            \'inactive\' 
                        END as exit_date
                from person_entry 
                order by person_ref,entry_date DESC
             )',
            'e',
            'e.person_ref=p.id'
        );

        $params = array();

        if ( $letter != '*' ) {
            $qb->where(
                "unaccent(regexp_replace(
                    upper(
                        left(
                            p.last_name,
                            1
                         )
                      ),
                      E'\\\d',
                      '#' 
                 )) = :letter"
            );
            $params['letter']=$letter;
        }

        $qb
            ->setMaxResults(500)
            ->orderBy('"firstLetter",last_name');
        $st = $conn->prepare($qb->getSQL());
        $st->execute($params);
        $dbResponse = $st->fetchAll();

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
     * @param string $active Tells if the filter on the active people
     * @param array $relatedFilters List of complementary filter options
     * @return array List of 3000 first found people in database
     */
    public function listAll($active = 'active', Array $relatedFilters = array()) {

        $SQL = $this->extractPeople($active, $relatedFilters);
        return $SQL->fetchAll();

    }
}
