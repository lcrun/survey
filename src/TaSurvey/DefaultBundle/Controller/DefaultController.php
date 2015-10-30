<?php
namespace TaSurvey\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TaSurvey\DefaultBundle\Entity\ExamStudent;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        $studentExams = $user->getStudentExams();

        return $this->render('TaSurveyDefaultBundle:Default:index.html.twig', array(
            'user' => $user,
            'studentExams' => $studentExams,
        ));
    }

//     public function numberAction(Request $request)
//     {
//         $number = $request->get('number');
//         $participated = $request->get('participated');
//         if (! $number) {
//             $this->get('session')
//                 ->getFlashBag()
//                 ->add('notice', '请正确填写学号');

//             return $this->redirect($this->generateUrl('default_homepage'));
//         }

//         $em = $this->getDoctrine()->getManager();
//         $numberUser = $em->getRepository('TaSurveyDefaultBundle:User')->findOneByNumber($number);
//         if ($numberUser) {
//             $this->get('session')
//                 ->getFlashBag()
//                 ->add('notice', '该学号已用其他登录码登录，请勿重复登录');

//             return $this->redirect($this->generateUrl('default_homepage'));
//         }

//         $user = $this->getUser();
//         $user->setNumber($number);
//         $user->setParticipated($participated);
//         $em->flush();

//         return $this->redirect($this->generateUrl('default_homepage'));
//     }

    public function examViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $exam = $em->getRepository('TaSurveyDefaultBundle:Exam')->find($id);
        if (! $exam) {
            throw $this->createNotFoundException('The exam does not exist');
        }
        $paper = $exam->getPaper();
        $user = $this->getUser();
        $questions = $user->getParticipated() ? array(
            17,
        ) : null;
        $paperNode = $paper->getPaperNode($questions);
        $paperHtml = $paperNode->getHtml();

        return $this->render('TaSurveyDefaultBundle:Default:exam.html.twig', array(
            'id' => $id,
            'exam' => $exam,
            'paperHtml' => $paperHtml,
        ));
    }

    public function examSubmitAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $exam = $em->getRepository('TaSurveyDefaultBundle:Exam')->find($id);
        if (! $exam) {
            throw $this->createNotFoundException('The exam does not exist');
        }

        $paper = $exam->getPaper();
        $paperNode = $paper->getPaperNode();
        $questionNodes = $paperNode->questionNodes;
        $questionNum = count($questionNodes);

        $answers = array();
        for ($i = 1; $i <= $questionNum; $i ++) {
            $answer = $request->get('question-'.$i); 
           
            if(is_array($answer )){ $answer =  json_encode($answer);}
            $answers[] = array(
                'id' => $i,
                'answer' => $answer,
            );
        }

        $student = $this->getUser();
        $examStudent = $em->getRepository('TaSurveyDefaultBundle:ExamStudent')->findOneBy(array(
            'exam' => $exam,
            'student' => $student,
        ));
        if ($examStudent->isDone()) {
            throw $this->createNotFoundException('你已经提交过，请勿重复提交');
        }
        $examStudent->setStatus(ExamStudent::STATUS_DONE);
        $examStudent->setAnswer($answers);
        $em->flush();

        $this->get('session')
            ->getFlashBag()
            ->add('notice', '提交成功');

        return $this->redirect($this->generateUrl('default_homepage'));
    }
}
