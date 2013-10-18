<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 26.09.13
 * Time: 17:03
 * To change this template use File | Settings | File Templates.
 */

namespace Controlcar\JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Controlcar\JournalBundle\Form\ActType;
use Controlcar\JournalBundle\Entity\Act;

class JournalController extends Controller
{
    public function deleteActAction($id)
    {
        $act = $this->getDoctrine()
            ->getRepository('ControlcarJournalBundle:Act')
            ->find($id);
        // delete act
        $em = $this->getDoctrine()->getManager();
        $em->remove($act);
        $em->flush();

        return $this->redirect($this->generateUrl('controlcar_journal_list'));
    }

    public function editActAction($id, Request $request)
    {
        $act = $this->getDoctrine()
            ->getRepository('ControlcarJournalBundle:Act')
            ->find($id);

        if($act === null)
        {
            return $this->redirect($this->generateUrl('controlcar_404'));
        }

        $form = $this->createForm(new ActType(), $act);

        if($_POST)
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirect($this->generateUrl('controlcar_journal_show_act',
                    array('id' => $act->getId())
                ));
            }
        }

        return $this->render('ControlcarJournalBundle:Journal:addForm.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }

    public function createDuplicateActAction($id)
    {
        $act = $this->getDoctrine()
            ->getRepository('ControlcarJournalBundle:Act')
            ->find($id);

        if($act === null)
        {
            return $this->redirect($this->generateUrl('controlcar_404'));
        }

        $act->setName(null);
        $act->setDate(new \DateTime());

        $form = $this->createForm(new ActType(), $act);
        return $this->render('ControlcarJournalBundle:Journal:addForm.html.twig',
            array(
                'form' => $form->createView()
            ));
    }

    public function listAction()
    {
        // show all acts with pager
        $acts = $this->getDoctrine()
            ->getRepository('ControlcarJournalBundle:Act')
            ->findAll();

        return $this->render('ControlcarJournalBundle:Journal:list.html.twig',
            array('acts' => $acts));
    }

    public function showActAction($id)
    {
        $act = $this->getDoctrine()
            ->getRepository('ControlcarJournalBundle:Act')
            ->find($id);

        if($act === null)
        {
            return $this->redirect($this->generateUrl('controlcar_404'));
        }

        return $this->render('ControlcarJournalBundle:Journal:act.html.twig',
            array('act' => $act)
        );
    }

    public function addActAction(Request $request)
    {
        $form = $this->createForm(new ActType(), new Act());
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $act = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($act);
            $em->flush();
            return $this->redirect($this->generateUrl('controlcar_journal_show_act',
                array('id' => $act->getId())
            ));
        }

        return $this->render('ControlcarJournalBundle:Journal:addForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
}