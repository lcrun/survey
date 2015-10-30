<?php
namespace TaSurvey\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TaSurvey\DefaultBundle\Entity\User;
use TaSurvey\DefaultBundle\Form\UserType;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class UserController extends Controller
{
    protected function getAdminListUrl()
    {
        return $this->generateUrl('admin_user');
    }

    public function indexAction(Request $request)
    {
        $key = $request->get('key', '');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('TaSurveyDefaultBundle:User')->getSearchQuery($key);
        $pagination = $this->get('knp_paginator')->paginate($query, $this->get('request')->query->get('page', 1));

        return $this->render('TaSurveyAdminBundle:User:index.html.twig', array(
            'pagination' => $pagination,
            'key' => $key,
        ));
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();

        $formType = $this->createForm(new UserType(), $user);
        $backLink = $this->getAdminListUrl();
        $formType->handleRequest($request);

        if ($formType->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('notice', '操作成功！');

            return $this->redirect($backLink);
        }

        $form = $formType->createView();
        $title = "用户";

        return $this->render('TaSurveyAdminBundle:User:new.html.twig', compact('form', 'title', 'backLink'));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TaSurveyDefaultBundle:User')->find($id);
        if (! $user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        $formType = $this->createForm(new UserType(), $user);
        $backLink = $this->getAdminListUrl();
        $formType->handleRequest($request);

        if ($formType->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('notice', '操作成功');

            return $this->redirect($backLink);
        }

        $form = $formType->createView();
        $title = "用户";

        return $this->render('TaSurveyAdminBundle:User:edit.html.twig', compact('form', 'title', 'backLink', 'id'));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('TaSurveyDefaultBundle:User')->find($id);
        if (! $user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        $em->remove($user);
        $em->flush();

        $this->get('session')
            ->getFlashBag()
            ->add('notice', '操作成功');

        return $this->redirect($this->getAdminListUrl());
    }
}
