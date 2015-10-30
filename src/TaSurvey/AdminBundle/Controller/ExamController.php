<?php
namespace TaSurvey\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use TaSurvey\DefaultBundle\Entity\Exam;
use TaSurvey\DefaultBundle\Form\ExamType;
use TaSurvey\DefaultBundle\Entity\ExamStudent;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class ExamController extends Controller
{
    protected function getAdminListUrl()
    {
        return $this->generateUrl('admin_exam');
    }

    public function indexAction(Request $request)
    {
        $key = $request->get('key', '');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('TaSurveyDefaultBundle:Exam')->getSearchQuery($key);
        $pagination = $this->get('knp_paginator')->paginate($query, $this->get('request')->query->get('page', 1));

        return $this->render('TaSurveyAdminBundle:Exam:index.html.twig', array(
            'pagination' => $pagination,
            'key' => $key,
        ));
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exam = new Exam();

        $formType = $this->createForm(new ExamType(), $exam);
        $backLink = $this->getAdminListUrl();
        $formType->handleRequest($request);

        if ($formType->isValid()) {
            $em->persist($exam);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('notice', '操作成功！');

            return $this->redirect($backLink);
        }

        $form = $formType->createView();
        $title = "调查";

        return $this->render('TaSurveyAdminBundle:Exam:new.html.twig', compact('form', 'title', 'backLink'));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $exam = $em->getRepository('TaSurveyDefaultBundle:Exam')->find($id);
        if (! $exam) {
            throw $this->createNotFoundException('The exam does not exist');
        }

        $formType = $this->createForm(new ExamType(), $exam);
        $backLink = $this->getAdminListUrl();
        $formType->handleRequest($request);

        if ($formType->isValid()) {
            $em->persist($exam);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('notice', '操作成功');

            return $this->redirect($backLink);
        }

        $form = $formType->createView();
        $title = "调查";

        return $this->render('TaSurveyAdminBundle:Exam:edit.html.twig', compact('form', 'title', 'backLink', 'id'));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $exam = $em->getRepository('TaSurveyDefaultBundle:Exam')->find($id);
        if (! $exam) {
            throw $this->createNotFoundException('The exam does not exist');
        }

        $em->remove($exam);
        $em->flush();

        $this->get('session')
            ->getFlashBag()
            ->add('notice', '操作成功');

        return $this->redirect($this->getAdminListUrl());
    }

    public function answersAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $exam = $em->getRepository('TaSurveyDefaultBundle:Exam')->find($id);
        if (! $exam) {
            throw $this->createNotFoundException('The exam does not exist');
        }

        $paper = $exam->getPaper();
        $paperNode = $paper->getPaperNode();
        $questions = $paperNode->questionNodes;

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('TaSurveyDefaultBundle:ExamStudent')->getSearchQuery($id);
        $pagination = $this->get('knp_paginator')->paginate($query, $this->get('request')->query->get('page', 1));

        return $this->render('TaSurveyAdminBundle:Exam:answers.html.twig', array(
            'exam' => $exam,
            'pagination' => $pagination,
            'questions' => $questions,
        ));
    }

    public function answersDownloadAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $exam = $em->getRepository('TaSurveyDefaultBundle:Exam')->find($id);
        if (! $exam) {
            throw $this->createNotFoundException('The exam does not exist');
        }

        $response = new StreamedResponse(function () use ($em, $id) {
            $results = $em->getRepository("TaSurveyDefaultBundle:ExamStudent")->findBy(array(
                'exam' => $id,
                'status' => ExamStudent::STATUS_DONE,
            ));
            $fp = fopen('php://output', 'r+');

            foreach ($results as $result) {
                $answers = array_column($result->getAnswer(), 'answer');
                $formatAnswers = array_map(function ($answer) {
                    return iconv('UTF8', 'GBK', $answer);
                }, $answers);
                array_unshift($formatAnswers, iconv('UTF8', 'GBK', $result->getStudent()->formatParticipated()));
                array_unshift($formatAnswers, iconv('UTF8', 'GBK', $result->getStudent()->getCode()));
                array_unshift($formatAnswers, $result->getStudent()->getName());
                fputcsv($fp, $formatAnswers);
            }

            fclose($fp);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

        return $response;
    }
}
