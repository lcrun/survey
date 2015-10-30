<?php
namespace TaSurvey\DefaultBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use TaSurvey\DefaultBundle\Library\Factory\PaperFactory;

/**
 * 试卷.
 *
 * @ORM\Entity(repositoryClass="TaSurvey\DefaultBundle\Entity\Repository\PaperRepository")
 * @ORM\Table(name="paper")
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class Paper
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
     * @ORM\Column(type="json_array")
     */
    protected $detail;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="Exam", mappedBy="paper")
     */
    protected $exams;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->exams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Paper
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
     * Set detail.
     *
     * @param array $detail
     *
     * @return Paper
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail.
     *
     * @return array
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Paper
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Paper
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add exams.
     *
     * @param \TaSurvey\DefaultBundle\Entity\Exam $exams
     *
     * @return Paper
     */
    public function addExam(\TaSurvey\DefaultBundle\Entity\Exam $exams)
    {
        $this->exams[] = $exams;

        return $this;
    }

    /**
     * Remove exams.
     *
     * @param \TaSurvey\DefaultBundle\Entity\Exam $exams
     */
    public function removeExam(\TaSurvey\DefaultBundle\Entity\Exam $exams)
    {
        $this->exams->removeElement($exams);
    }

    /**
     * Get exams.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExams()
    {
        return $this->exams;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getPaperNode(array $questions = null)
    {
        return PaperFactory::createPaperNodeFromArray($this->detail, $questions);
    }
}
