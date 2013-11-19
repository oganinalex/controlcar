<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 26.09.13
 * Time: 17:03
 * To change this template use File | Settings | File Templates.
 */

namespace Controlcar\JournalBundle\Controller;

use Controlcar\JournalBundle\Entity\Car;
use Controlcar\JournalBundle\Entity\Transposition;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Controlcar\JournalBundle\Form\ActType;
use Controlcar\JournalBundle\Entity\Act;
use Controlcar\JournalBundle\Controller\DoxgenerationController;

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

        $form = $this->createForm(new ActType(), $act,  array(
                    'action' => $this->generateUrl('controlcar_journal_add_act'),
                    'method' => 'POST',));
        return $this->render('ControlcarJournalBundle:Journal:addForm.html.twig',
            array(
                'form' => $form->createView()
            ));
    }

    public function listAction()
    {
        $paginator  = $this->get('knp_paginator');

        $acts = $paginator->paginate(
            $this->getDoctrine()
                ->getRepository('ControlcarJournalBundle:Act')
                ->findAll(),
            $this->get('request')->query->get('page', 1),
            5
        );

        // parameters to template
        return $this->render('ControlcarJournalBundle:Journal:list.html.twig', array('acts' => $acts));

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

        if($this->getRequest()->getMethod() == 'POST')
        {
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
            else
            {
                var_dump($form->getErrors());
                exit;
            }
        }

        return $this->render('ControlcarJournalBundle:Journal:addForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createActDocxAction($pay, $id)
    {
        $act = $this->getAct($id);
        $dox_template = '';

        if ($pay === 'act' && $act->getTranspositionId() === '1')
        {
            $dox_template=__DIR__.'/../Resources/words/dist.docx';
        }
        elseif ($pay === 'act' && $act->getTranspositionId() === '2')
        {
            $dox_template=__DIR__.'/../Resources/words/stat.docx';
        }
        elseif ($pay === 'pay' && $act->getTranspositionId() === '1')
        {
            $dox_template=__DIR__.'/../Resources/words/pay_dist.docx';
        }
        elseif ($pay === 'pay' && $act->getTranspositionId() === '2')
        {
            $dox_template=__DIR__.'/../Resources/words/pay_stat.docx';
        }
        else
        {
            return $this->redirect($this->generateUrl('controlcar_404'));
        }

        return $this->generateDocxResponce($dox_template, $act);
    }

    private function setDocxValue($dox_template,Act $act)
    {
        $DoxGeneration = new DoxgenerationController($dox_template);
        $DoxGeneration->val('act_number', $act->getName());
        $DoxGeneration->val('date',$DoxGeneration->ukr_date("d.m.Y р",  strtotime($act->getDate()->format('Y-m-d'))));
        $DoxGeneration->val('price_by_km', $act->getPriceByKm());
        $DoxGeneration->val('dist', $act->getDistance());
        $DoxGeneration->val('number_trips', $act->getCountTransportation());
        $DoxGeneration->val('price_by_one', $act->getPriceByTransportation());
        $DoxGeneration->val('place_loading', $act->getDeparturePlace());
        $DoxGeneration->val('place_discharg', $act->getDestinationPlace());
        $DoxGeneration->val('sum', $this->getActSum($act));
        $DoxGeneration->val('sum_word', $DoxGeneration->num2str($this->getActSum($act)));
        $filename =  __DIR__.'/../Resources/words/Платежка_Акт_'.$act->getName().'_'.$act->getTransposition()->getName().
                     '_'.$act->getDeparturePlace().'-'.$act->getDestinationPlace().'_от_'.$act->getName().'.docx';
        $DoxGeneration->save($filename);

        return $filename;
    }

    private function setDocxHeaders($response, $filename)
    {
        $response->headers->set('Content-Description', 'File Transfer');
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $response->headers->set('Content-Disposition', 'attachment; filename='.basename($filename));
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Expires', '0');
        $response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Content-Length', filesize($filename));

        return $response;
    }

    private function getAct($id)
    {
        $act = $this->getDoctrine()
            ->getRepository('ControlcarJournalBundle:Act')
            ->find($id);

        /* @var $act Act()
         */

        if($act === null)
        {
            return $this->redirect($this->generateUrl('controlcar_404'));
        }

        return $act;
    }

    private function getActSum(Act $act)
    {
        if($act->getTranspositionId() === 1)
        {
            return ($act->getPriceByKm() * $act->getDistance());
        }

        return ($act->getCountTransportation() * $act->getPriceByTransportation());
    }

    private function generateDocxResponce($dox_template, $act)
    {
        $filename = $this->setDocxValue($dox_template, $act);
        $docxContent = file_get_contents($filename);
        $responce = $this->setDocxHeaders(new Response($docxContent), $filename);

        unlink($filename);

        return $responce;
    }

    public function parseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $file = __DIR__.'/../Resources/csv/test.csv';
        $fHandler = fopen($file, 'r');
        while($row = (array)fgetcsv($fHandler))
        {
            $act = new Act();
            $act->setId($row[0]);
            $act->setCar($this->getDoctrine()
                ->getRepository('ControlcarJournalBundle:Car')
                ->find($row[1]));
            $act->setName($row[2]);
            $act->setDate(\DateTime::createFromFormat('Y-m-d', $row[3]));
            $act->setWeight($row[4]);
            $act->setCargoType($row[5]);
            $act->setTransposition($this->getDoctrine()
                ->getRepository('ControlcarJournalBundle:Transposition')
                ->find($row[6]));
            $act->setPriceByKm($row[7]);
            $act->setDistance($row[8]);
            $act->setCountTransportation($row[9]);
            $act->setPriceByTransportation($row[10]);
            $act->setDeparturePlace(mb_convert_encoding($row[11], 'UTF-8', 'cp1251'));
            $act->setDestinationPlace(mb_convert_encoding($row[12], 'UTF-8', 'cp1251'));
            $act->setEditTime(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $row[13])));

            $em->persist($act);
            $em->flush();
        }
        fclose($fHandler);
        exit;
    }
}