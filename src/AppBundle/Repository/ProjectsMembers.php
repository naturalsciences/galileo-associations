<?php

namespace AppBundle\Repository;

/**
 * ProjectsMembers
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectsMembers extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $projectId The identifier of the project
     * @return array The array of members with activity date
     */
    public function listMembers($projectId) {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select("p.id as id,
                     pm.id as related_id,
                     p.last_name,
                     TRIM(CONCAT(p.first_name,CONCAT(' ', p.last_name))) as name,
                     CASE WHEN EXISTS
                     (
                        SELECT CASE 
                                    WHEN pe.exit_date IS NULL OR pe.exit_date > CURRENT_TIMESTAMP THEN
                                        'active'
                                    ELSE
                                        'inactive'
                               END
                        FROM person_entry pe
                        WHERE pe.person_ref = p.id
                        ORDER BY pe.entry_date DESC
                        LIMIT 1
                     ) THEN
                     (
                        SELECT CASE 
                                    WHEN pe.exit_date IS NULL OR pe.exit_date > CURRENT_TIMESTAMP THEN
                                        'active'
                                    ELSE
                                        'inactive'
                               END
                        FROM person_entry pe
                        WHERE pe.person_ref = p.id
                        ORDER BY pe.entry_date DESC
                        LIMIT 1
                     )
                     ELSE
                       'active'
                     END as active,
                     pm.start_date,
                     pm.end_date")
            ->from('projects_members', 'pm')
            ->innerJoin('pm', 'person', 'p', 'pm.person_ref = p.id')
            ->where('pm.project_ref = :project_id')
            ->orderBy('pm.end_date DESC, pm.start_date DESC, p.last_name')
            ->setParameter('project_id', $projectId);

        $query_prepared = $conn->prepare($qb->getSQL());
        $query_prepared->execute($qb->getParameters());

        return $query_prepared->fetchAll();

    }

    /**
     * @param int $personId The identifier of the person
     * @param string $locale The identifier of the locale
     * @return array The array of projects with activity date
     */
    public function listProjects($personId, $locale='en') {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->select("p.id as id,
                     pm.id as related_id,
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
                     END as name,
                     CASE 
                        WHEN p.end_date IS NULL OR p.end_date > CURRENT_TIMESTAMP then
                            'active'
                        ELSE
                            'inactive'
                     END as active,
                     pm.start_date,
                     pm.end_date")
            ->from('projects_members', 'pm')
            ->innerJoin('pm', 'projects', 'p', 'pm.project_ref = p.id')
            ->where('pm.person_ref = :person_id')
            ->orderBy('pm.end_date DESC, pm.start_date DESC, name')
            ->setParameter('person_id', $personId)
            ->setParameter('locale', $locale);

        $query_prepared = $conn->prepare($qb->getSQL());
        $query_prepared->execute($qb->getParameters());

        return $query_prepared->fetchAll();

    }

}
