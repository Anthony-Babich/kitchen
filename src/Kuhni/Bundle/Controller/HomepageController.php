<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\CallBack;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;

class HomepageController extends Controller
{
    private $session;
    public function __construct()
    {
        $this->session = new Session();
        $this->session->set('likeKuhniProduct', 0);
    }

    public function indexAction()
    {
        //Создаем построитель запросов Doctrine
        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n');
        //Добавляем к запросу left join c сущностью "Категория"
        //при выводе в списке названия категории нового запроса не будет
        $qb->select('n')->orderBy('n.id');
        $result = $qb->getQuery()->getResult();

        if (!empty($result)){
            foreach ($result as $item) {
                $image[] = 'upload/catalog/' . $item->getImageName();
            }
        }

        $callback = new CallBack();
//+7(___)___-____
        $form = $this->createFormBuilder($callback)
            ->add('name', TextType::class, array('attr' => ['placeholder' => 'ВАШЕ ИМЯ *', 'class' => 'form-control'], 'label' => false))
            ->add('email', EmailType::class, array('label' => false, 'attr' => ['placeholder' => 'Ваш EMAIL *', 'class' => 'form-control']))
            ->add('phone', PhoneNumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
                'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
                'format' => PhoneNumberFormat::NATIONAL,
                'country_choices' => array('UA', 'BY', 'RU', 'KZ', 'PL', 'LT', 'LV'),
                'preferred_country_choices' => array('RU'),
            ))
            ->add('message', TextareaType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ваше Сообщение *',
                    'class' => 'form-control'
                ]
            ))
            ->getForm();

        if (!empty($image)){
            return $this->render('homepage/index.html.twig', array(
                'form' => $form->createView(),
                'catalog' => $result,
                'image' => $image,
            ));
        }
    }
}
