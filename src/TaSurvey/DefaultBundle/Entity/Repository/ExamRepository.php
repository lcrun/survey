<?php
namespace TaSurvey\DefaultBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ExamRepository.
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ExamRepository extends EntityRepository
{
    public function getSearchQuery($key = '')
    {
        $dql = "SELECT e FROM TaSurveyDefaultBundle:Exam e WHERE e.title LIKE :key";
        $query = $this->getEntityManager()->createQuery($dql);
        $query = $query->setParameter('key', "%$key%");

        return $query;
    }
}
