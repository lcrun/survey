<?php
namespace TaSurvey\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 考试考生.
 *
 * @ORM\Entity(repositoryClass="TaSurvey\DefaultBundle\Entity\Repository\ExamStudentRepository")
 * @ORM\Table(name="exam_student")
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ExamStudent
{
    const STATUS_NEW = 'new'; // 未提交

    const STATUS_DONE = 'done'; // 已提交

    /**
     * ID.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * 答案.
     *
     * @ORM\Column(type="json_array")
     */
    protected $answer = array();

    /**
     * 得分.
     *
     * @ORM\Column(type="integer")
     */
    protected $score = 0;

    /**
     * 状态.
     *
     * @ORM\Column(type="string", length=10)
     */
    protected $status = self::STATUS_NEW;

    /**
     * @ORM\ManyToOne(targetEntity="Exam", inversedBy="examStudents")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
    protected $exam;

    /**
     * @ORM\ManyToOne(targetEntity="TaSurvey\DefaultBundle\Entity\User", inversedBy="studentExams")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    protected $student;

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
     * Set answer.
     *
     * @param array $answer
     *
     * @return ExamStudent
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer.
     *
     * @return array
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set score.
     *
     * @param integer $score
     *
     * @return ExamStudent
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score.
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return ExamStudent
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set exam.
     *
     * @param \TaSurvey\DefaultBundle\Entity\Exam $exam
     *
     * @return ExamStudent
     */
    public function setExam(\TaSurvey\DefaultBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam.
     *
     * @return \TaSurvey\DefaultBundle\Entity\Exam
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set student.
     *
     * @param \TaSurvey\DefaultBundle\Entity\User $student
     *
     * @return ExamStudent
     */
    public function setStudent(User $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student.
     *
     * @return \TaSurvey\DefaultBundle\Entity\User
     */
    public function getStudent()
    {
        return $this->student;
    }

    public function isDone()
    {
        return $this->status == self::STATUS_DONE;
    }

    public function getFormatStatus()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return '未提交';
            case self::STATUS_DONE:
                return '已提交';
        }
    }
}
