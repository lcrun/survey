<?php
namespace TaSurvey\DefaultBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * 考试.
 *
 * @ORM\Entity(repositoryClass="TaSurvey\DefaultBundle\Entity\Repository\ExamRepository")
 * @ORM\Table(name="exam")
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class Exam
{
    /**
     * ID.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * 名称.
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * 截止日期.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    protected $deadline;

    /**
     * @ORM\ManyToOne(targetEntity="Paper", inversedBy="exams")
     * @ORM\JoinColumn(name="paper_id", referencedColumnName="id")
     */
    protected $paper;

    /**
     * @ORM\OneToMany(targetEntity="ExamStudent", mappedBy="exam")
     */
    protected $examStudents;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->examStudents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Exam
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set deadline.
     *
     * @param \DateTime $deadline
     *
     * @return Exam
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline.
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set paper.
     *
     * @param \TaSurvey\DefaultBundle\Entity\Paper $paper
     *
     * @return Exam
     */
    public function setPaper(\TaSurvey\DefaultBundle\Entity\Paper $paper = null)
    {
        $this->paper = $paper;

        return $this;
    }

    /**
     * Get paper.
     *
     * @return \TaSurvey\DefaultBundle\Entity\Paper
     */
    public function getPaper()
    {
        return $this->paper;
    }

    /**
     * Add examStudents.
     *
     * @param \TaSurvey\DefaultBundle\Entity\ExamStudent $examStudents
     *
     * @return Exam
     */
    public function addExamStudent(\TaSurvey\DefaultBundle\Entity\ExamStudent $examStudents)
    {
        $this->examStudents[] = $examStudents;

        return $this;
    }

    /**
     * Remove examStudents.
     *
     * @param \TaSurvey\DefaultBundle\Entity\ExamStudent $examStudents
     */
    public function removeExamStudent(\TaSurvey\DefaultBundle\Entity\ExamStudent $examStudents)
    {
        $this->examStudents->removeElement($examStudents);
    }

    /**
     * Get examStudents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExamStudents()
    {
        return $this->examStudents;
    }

    public function getValidExamStudents()
    {
        return array_filter($this->examStudents->toArray(), function ($examStudent) {
            return $examStudent->getStatus() == ExamStudent::STATUS_DONE;
        });
    }

    public function getValidExamStudentCount()
    {
        return count($this->getValidExamStudents());
    }
}
