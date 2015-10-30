<?php

namespace TaSurvey\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author wendell.zheng <wxzheng@ustc.edu.cn>
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TaSurveyAdminBundle:Default:index.html.twig');
    }
}
