<?php
namespace TaSurvey\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TaSurvey\DefaultBundle\Entity\Paper;
use TaSurvey\DefaultBundle\Form\PaperType;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class PaperController extends Controller
{
    protected function getAdminListUrl()
    {
        return $this->generateUrl('admin_paper');
    }

    public function indexAction(Request $request)
    {
        $key = $request->get('key', '');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('TaSurveyDefaultBundle:Paper')->getSearchQuery($key);
        $pagination = $this->get('knp_paginator')->paginate($query, $this->get('request')->query->get('page', 1));

        return $this->render('TaSurveyAdminBundle:Paper:index.html.twig', array(
            'pagination' => $pagination,
            'key' => $key,
        ));
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paper = new Paper();

        $formType = $this->createForm(new PaperType(), $paper);
        $backLink = $this->getAdminListUrl();
        $formType->handleRequest($request);

        if ($formType->isValid()) {
            $em->persist($paper);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('notice', '操作成功！');

            return $this->redirect($backLink);
        }

        $form = $formType->createView();
        $title = "试卷";

        return $this->render('TaSurveyAdminBundle:Paper:new.html.twig', compact('form', 'title', 'backLink'));
    }

    public function previewAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paper = $em->getRepository('TaSurveyDefaultBundle:Paper')->find($id);
        if (! $paper) {
            throw $this->createNotFoundException('The paper does not exist');
        }

        $paperNode = $paper->getPaperNode();
        $paperHtml = $paperNode->getHtml();
        $backLink = $this->getAdminListUrl();

        return $this->render('TaSurveyAdminBundle:Paper:preview.html.twig', compact('id', 'paper', 'backLink', 'paperHtml'));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $paper = $em->getRepository('TaSurveyDefaultBundle:Paper')->find($id);
        if (! $paper) {
            throw $this->createNotFoundException('The paper does not exist');
        }

        $em->remove($paper);
        $em->flush();

        $this->get('session')
            ->getFlashBag()
            ->add('notice', '操作成功');

        return $this->redirect($this->getAdminListUrl());
    }
}
