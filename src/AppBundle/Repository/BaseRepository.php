<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 24/11/16
 * Time: 12:11
 */

namespace AppBundle\Repository;


abstract class BaseRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param string $active
     * @param array $relatedFilters
     * @return mixed
     */
    abstract public function listAll($active = 'active', Array $relatedFilters = array());

    /**
     * @param string $active Tells if we need to filter on active, non active or none "active" parameter
     * @param array $relatedFilters List of complementary filters to apply
     * @return \Doctrine\DBAL\Driver\Statement
     */
    protected function extractProjectsTeams($table = 'projects', $active = 'active', Array $relatedFilters = array())
    {
        $conn = $this->getEntityManager()->getConnection();
        $qb = $conn->createQueryBuilder();
        $params = array();
        $qb->select('DISTINCT pt.id, 
                        pt.international_name, 
                        pt.international_description,
                        pt.name_en,
                        pt.description_en,
                        pt.name_nl,
                        pt.description_nl,
                        pt.name_fr,
                        pt.description_fr,
                        pt.international_name_language,
                        case when pt.end_date is null then \'active\' when pt.end_date >= now() then \'active\' else \'inactive\' end as "active"
                    ')
            ->from($table, 'pt')
            ->orderBy('pt.international_name');

        if ( in_array($active, array('active', 'inactive')) ) {
            $qb->andWhere('case when pt.end_date is null then \'active\' when pt.end_date >= now() then \'active\' else \'inactive\' end = ?');
            $params[] = $active;
        }

        $this->composeNamingWhere($qb, $params, $relatedFilters, 'pt.international_name', 'names');

        $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'pt.id', 'ids');

        if ( isset($relatedFilters['teams'] ) && $table === 'projects' ) {
            if ( is_array($relatedFilters['teams']) ) {
                if (count($relatedFilters['teams']) > 0) {
                    $qb->innerJoin(
                        'pt',
                        'teams_projects',
                        'tp',
                        'pt.id = tp.project_ref'
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'tp.team_ref', 'teams');
                }
            }
        }

        if ( isset($relatedFilters['projects'] ) && $table === 'teams') {
            if ( is_array($relatedFilters['projects']) ) {
                if (count($relatedFilters['projects']) > 0) {
                    $qb->innerJoin(
                        'pt',
                        'teams_projects',
                        'tp',
                        'pt.id = tp.team_ref'
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'tp.project_ref', 'projects');
                }
            }
        }

        if ( isset($relatedFilters['people'] ) ) {
            if ( is_array($relatedFilters['people']) ) {
                if (count($relatedFilters['people']) > 0) {

                    $targetTable = ($table === 'projects')?'projects_members':'teams_members';
                    $targetField = ($table === 'projects')?'project_ref':'team_ref';

                    $qb->innerJoin(
                        'pt',
                        $targetTable,
                        'tpm',
                        'pt.id = tpm.'.$targetField
                    );
                    $this->composeNumericWhereIn($qb, $params, $relatedFilters, 'tpm.person_ref', 'people');
                }
            }
        }

        $qb
            ->setMaxResults(2000);
        $st = $conn->prepare($qb->getSQL());
        $st->execute($params);
        return $st;
    }
    
    /**
     * @param \Doctrine\DBAL\Query\QueryBuilder $qb
     * @param array $params
     * @param array $relatedFilters
     * @param $whereElement
     * @param $elementConcerned
     */
    protected function composeNumericWhereIn(\Doctrine\DBAL\Query\QueryBuilder &$qb, Array &$params, Array $relatedFilters, $whereElement, $elementConcerned) {
        if ( isset($relatedFilters[$elementConcerned]) ) {
            if ( is_array($relatedFilters[$elementConcerned]) ) {
                if ( count($relatedFilters[$elementConcerned]) > 0 ) {
                    $sqlWhere = '(';
                    foreach( $relatedFilters[$elementConcerned] as $value ) {
                        if ( is_numeric($value) ) {
                            $sqlWhere .= '?,';
                            $params[] = $value;
                        }
                    }
                    $sqlWhere = rtrim($sqlWhere, ',');
                    $sqlWhere .= ')';
                    if ($sqlWhere !== '()') {
                        $qb->andWhere($whereElement . ' IN ' . $sqlWhere);
                    }
                }
            }
        }
    }

    /**
     * @param \Doctrine\DBAL\Query\QueryBuilder $qb
     * @param array $params
     * @param array $relatedFilters
     * @param $whereElement
     * @param $elementConcerned
     */
    protected function composeNamingWhere(\Doctrine\DBAL\Query\QueryBuilder &$qb, Array &$params, Array $relatedFilters, $whereElement, $elementConcerned) {
        if ( isset($relatedFilters[$elementConcerned]) ) {
            if ( is_array($relatedFilters[$elementConcerned]) ) {
                if ( count($relatedFilters[$elementConcerned]) > 0 ) {
                    $sqlWhere = '';
                    foreach( $relatedFilters[$elementConcerned] as $value ) {
                        $sqlWhere .= 'unaccent('.$whereElement.') ilike \'%\' || unaccent(?) || \'%\' OR ';
                        $params[] = $value;
                    }
                    $sqlWhere = trim(rtrim(trim($sqlWhere), 'OR'));
                    $qb->andWhere($sqlWhere);
                }
            }
        }
    }

    /**
     * @param string $active Tells if the filter on the active teams
     * @param int $id Id of the project to retrieve
     * @param array $relatedFilters List of complementary filter options
     * @return array $response an array of teams entries found
     */
    public function listById($active = 'active', $id, Array $relatedFilters = array()) {

        $relatedFilters['ids'] = $id;
        return $this->listAll($active, $relatedFilters);

    }

    /**
     * @param string $active Tells if the filter on the active teams
     * @param string $name Name part to search on
     * @param array $relatedFilters List of complementary filter options
     * @return array $response an array of project entries found
     */
    public function listByName($active = 'active', $name, Array $relatedFilters = array()) {

        $relatedFilters['names'] = $name;
        return $this->listAll($active, $relatedFilters);

    }
}