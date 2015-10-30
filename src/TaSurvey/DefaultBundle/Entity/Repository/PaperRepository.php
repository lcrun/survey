<?php
namespace TaSurvey\DefaultBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PaperRepository.
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class PaperRepository extends EntityRepository
{
    public function getSearchQuery($key = '')
    {
        $dql = "SELECT e FROM TaSurveyDefaultBundle:Paper e WHERE e.title LIKE :key";
        $query = $this->getEntityManager()->createQuery($dql);
        $query = $query->setParameter('key', "%$key%");

        return $query;
    }
}
