<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\ZovZakaz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ZovZakazController extends Controller
{
    public function indexAction(){
        return $this->render('ZovZakaz/zovzakazForm.html.twig', array(
            'formZovZakaz' => $this->getZovZakazForm(),
        ));
    }

    public function newZakazAction(Request $request){
        $form = $request->get('form');
        $number = htmlspecialchars($form['number']);
        $ordernumber = htmlspecialchars($form['orderNumber']);
        $date = htmlspecialchars($form['date']);

        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $call = new ZovZakaz();

        $salon = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Salon')
            ->findOneBy(array('id' => $form['idSalon']));

        $call->setNumber($number);
        $call->setIdSalon($salon);
        $call->setOrderNumber($ordernumber);
        $call->setDate(new \DateTime($date));
        $entityManager->persist($call);
        $entityManager->flush();

        $response = json_encode(array('success' => 'success'));
        return new Response($response);
    }

    private function getZovZakazForm()
    {
        $requestCall = new ZovZakaz();

        $formRequestCall = $this->createFormBuilder($requestCall)
            ->add('number', TextType::class, array(
                'attr' => [
                    'placeholder' => 'как в договоре',
                    'class' => 'form-control'
                ],
                'label' => 'Номер договора'
            ))
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'placeholder' => 'дд-мм-гггг',
                    'class' => 'form-control input-inline js-datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                ],
                'label' => 'Дата договора'
            ))
            ->add('orderNumber', TextType::class, array(
                'attr' => [
                    'placeholder' => 'я1754-тд18',
                    'class' => 'form-control',
                ],
                'label' => 'Номер сверенного заказа с менеджером ЗОВ'
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'KuhniBundle:Salon',
                'property' => 'title',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Выберите ВАШ салон',
            ))
            ->getForm()->createView();

        return $formRequestCall;
    }
}