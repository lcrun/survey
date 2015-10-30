<?php
namespace TaSurvey\DefaultBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ExamStudentRepository.
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ExamStudentRepository extends EntityRepository
{
    public function getSearchQuery($examId)
    {
        $dql = "SELECT e FROM TaSurveyDefaultBundle:ExamStudent e LEFT JOIN e.exam ex LEFT JOIN e.student s WHERE ex.id = :examId ORDER BY e.status ASC,
            s.participated DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('examId', $examId);

        return $query;
    }
}
