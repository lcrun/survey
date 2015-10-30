<?php
namespace TaSurvey\DefaultBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * 用户.
 *
 * @ORM\Entity(repositoryClass="TaSurvey\DefaultBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity("code")
 *
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class User implements UserInterface, \Serializable
{
    const ROLE_USER = 'ROLE_USER';

    const ROLE_ADMIN = 'ROLE_ADMIN';

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 学号/工资号.
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $number;

    /**
     * 姓名.
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $name;

    /**
     * 性别.
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Choice(callback = {"Util", "getGenders"})
     */
    protected $gender;

    /**
     * 院系.
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $department;

    /**
     * 学科.
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $subject;

    /**
     * 手机.
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $mobile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $info;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $remark;

    /**
     * 是否参加过培训.
     *
     * @ORM\Column(type="boolean")
     */
    protected $participated = false;

    /**
     * 登录码.
     *
     * @ORM\Column(type="string", length=60, unique=true)
     */
    protected $code;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $roles;

    /**
     * @ORM\OneToMany(targetEntity="ExamStudent", mappedBy="student")
     */
    protected $studentExams;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->roles = array();
        $this->studentExams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set number.
     *
     * @param string $number
     *
     * @return User
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set participated.
     *
     * @param boolean $participated
     *
     * @return User
     */
    public function setParticipated($participated)
    {
        $this->participated = $participated;

        return $this;
    }

    /**
     * Get participated.
     *
     * @return boolean
     */
    public function getParticipated()
    {
        return $this->participated;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return User
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add studentExams.
     *
     * @param \TaSurvey\DefaultBundle\Entity\ExamStudent $studentExams
     *
     * @return User
     */
    public function addStudentExam(\TaSurvey\DefaultBundle\Entity\ExamStudent $studentExams)
    {
        $this->studentExams[] = $studentExams;

        return $this;
    }

    /**
     * Remove studentExams.
     *
     * @param \TaSurvey\DefaultBundle\Entity\ExamStudent $studentExams
     */
    public function removeStudentExam(\TaSurvey\DefaultBundle\Entity\ExamStudent $studentExams)
    {
        $this->studentExams->removeElement($studentExams);
    }

    /**
     * Get studentExams.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentExams()
    {
        return $this->studentExams;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set department.
     *
     * @param string $department
     *
     * @return User
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return User
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set mobile.
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile.
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set info.
     *
     * @param string $info
     *
     * @return User
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info.
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set remark.
     *
     * @param string $remark
     *
     * @return User
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark.
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set roles.
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_USER) {
            return $this;
        }

        if (! in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Returns the user roles.
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * Never use this to check if this user has access to anything!
     *
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *
     * $securityContext->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->code,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->code) = unserialize($serialized);
    }

    public function isParticipated()
    {
        if (! $this->number) {
            return '--';
        } else {
            return $this->participated ? '是' : '否';
        }
    }

    public function formatParticipated()
    {
        if (! $this->number) {
            return '--';
        } else {
            return $this->participated ? '参加过' : '未参加过';
        }
    }
}
