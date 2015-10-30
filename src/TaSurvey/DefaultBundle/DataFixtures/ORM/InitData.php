<?php
namespace TaSurvey\DefaultBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use TaSurvey\DefaultBundle\Entity\User;
use TaSurvey\DefaultBundle\Entity\Paper;
use TaSurvey\DefaultBundle\Entity\Exam;
use TaSurvey\DefaultBundle\Entity\ExamStudent;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class InitData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $appPath = $this->container->get('kernel')->getRootDir();
        $dataPath = $appPath."/../data";

        // 超级管理员
        $super = new User();
        $super->setCode('wendell!');
        $super->addRole(User::ROLE_SUPER_ADMIN);
        $manager->persist($super);

        $paperJson = $dataPath."/paper.json";
        $paperData = json_decode(file_get_contents($paperJson));
        $paper = new Paper();
        $paper->setTitle($paperData->title);
        $paper->setDetail($paperData);
        $manager->persist($paper);

        $exam = new Exam();
        $exam->setPaper($paper);
        $exam->setTitle($paper->getTitle());
        $deadline = new \DateTime("2015-11-10");
        $exam->setDeadline($deadline);
        $manager->persist($exam);

        $codeJson = $dataPath."/codes.json";
        $codes = json_decode(file_get_contents($codeJson));
        foreach ($codes as $code) {
            $user = new User();
            $user->setName(trim($code[0]));
             $user->setCode(trim($code[1]));
              $user->setMobile(trim($code[2]));
            $user->setGender(trim($code[3]));
            $user->setDepartment(trim($code[4]));
           // $user->setSubject(trim($code[3]));
            //$user->setInfo(trim($code[4]));
            //$user->setNumber(trim($code[5]));
           
           
          //  $user->setRemark(trim($code[8]));
            $manager->persist($user);

            $examStudent = new ExamStudent();
            $examStudent->setExam($exam);
            $examStudent->setStudent($user);
            $manager->persist($examStudent);
        }

        // $examStudent = new ExamStudent();
        // $examStudent->setExam($exam);
        // $examStudent->setStudent($super);
        // $manager->persist($examStudent);

        $manager->flush();
    }
}
