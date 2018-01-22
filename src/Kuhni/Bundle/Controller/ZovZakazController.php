<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Form\Search\ZovZakazType as SearchProductsType;
use Kuhni\Bundle\Entity\Search\ZovZakaz as SearchProducts;
use Doctrine\ORM\EntityRepository;
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

    public function trackAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $searchProducts = new SearchProducts();
        $searchForm = $this->createForm(new SearchProductsType($em), $searchProducts);

        return $this->render('ZovZakaz/trackingForm.html.twig', array(
            'searchForm' => $searchForm->createView(),
        ));
    }

    public function trackCheckAction(Request $request){
        $searchorg = $request->get('searchorg');
        $number = htmlspecialchars($searchorg['number']);
        $date = htmlspecialchars($searchorg['date']);
        $date = \DateTime::createFromFormat("d-m-Y", $date);
        $idSalon = htmlspecialchars($searchorg['idSalon']);

        $qb = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:ZovZakaz')
            ->createQueryBuilder('n')
            ->select('t.status')
            ->innerJoin('n.idStatus', 't')
            ->where('1 = 1');
        if (!empty($number)){
            $qb->andWhere('n.number LIKE :number')
                ->setParameter('number', $number);
            if (!empty($date)){
                $qb->andWhere('n.date = :date')
                    ->setParameter('date', $date->format('Y-m-d'));
                if (!empty($idSalon)){
                    $qb->andWhere('n.idSalon = :idSalon')
                        ->setParameter('idSalon', $idSalon);
                }
            }
        }
        $res = $qb
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (!empty($res)){
            return new Response(json_encode(array('success' => 'success', 'result' => $res[0]['status'])));
        }else{
            return new Response(json_encode(array('success' => 'noSuccess')));
        }

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
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->andWhere('u.id <> 2')->orderBy('u.id', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'property' => 'title',
                'label' => 'Выберите ВАШ салон',
            ))
            ->add('idStatus', EntityType::class, array(
                'class' => 'KuhniBundle:ZovZakazStatus',
                'attr' => [
                    'class' => 'form-control',
                ],
                'property' => 'status',
                'label' => 'Укажите статус заказа',
            ))
            ->getForm()->createView();

        return $formRequestCall;
    }
}