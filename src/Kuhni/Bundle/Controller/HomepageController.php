<?php

namespace Kuhni\Bundle\Controller;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityRepository;
use Kuhni\Bundle\Entity\CallBack;
use Kuhni\Bundle\Entity\CostProject;
use Kuhni\Bundle\Entity\DesignerAtHome;
use Kuhni\Bundle\Entity\DesignProjectShag;
use Kuhni\Bundle\Entity\FasadColor;
use Kuhni\Bundle\Entity\freeDesignProject;
use Kuhni\Bundle\Entity\Kuhni;
use Kuhni\Bundle\Entity\RequestCall;
use Kuhni\Bundle\Entity\Reviews;
use Kuhni\Bundle\Entity\ZayavkaRazmer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Vich\UploaderBundle\Form\Type\VichImageType;

class HomepageController extends Controller
{
    private $session;
    private $colorStation;
    public function __construct()
    {
        $this->session = new Session();
        $this->session->set('likeKuhniProduct', 0);
    }

    public function indexAction()
    {
        //Создаем построитель запросов Doctrine
        $result = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Catalog')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.id')
            ->getQuery()
            ->getResult();

        if (!empty($result)){
            foreach ($result as $item) {
                $image[] = 'upload/catalog/' . $item->getImageName();
            }
        }

        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $kuhnione = $entityManager->getRepository('KuhniBundle:Kuhni')
            ->findOneById(1);
        $kuhnitwo = $entityManager->getRepository('KuhniBundle:Kuhni')
            ->findOneById(2);
        $kuhnimatone = $entityManager->getRepository('KuhniBundle:KuhniMaterial')
            ->findOneById(1);
        $call = new FasadColor();

        $call->setIdKuhniMaterial($kuhnimatone);
        $call->setKuhnies($kuhnione);
        $call->addKuhnies($kuhnitwo);
        $call->setName('art');
        $call->setTitle('art');
        $call->setAlt('art');
        $call->setImageName('art');
        $call->setImageSize(1024);
        $call->setUpdated(new \DateTime());
        $entityManager->persist($call);
        $entityManager->flush();

//        $catalogone = $entityManager->getRepository('KuhniBundle:Catalog')
//            ->findOneById(1);
//        $styleone = $entityManager->getRepository('KuhniBundle:KuhniStyle')
//            ->findOneById(1);
//        $colorone = $entityManager->getRepository('KuhniBundle:KuhniColor')
//            ->findOneById(1);
//        $materialone = $entityManager->getRepository('KuhniBundle:KuhniMaterial')
//            ->findOneById(1);
//        $configone = $entityManager->getRepository('KuhniBundle:KuhniConfig')
//            ->findOneById(1);
//        $fasadeOne = $entityManager->getRepository('KuhniBundle:FasadColor')
//            ->findOneById(1);
//        $fasadeTwo = $entityManager->getRepository('KuhniBundle:FasadColor')
//            ->findOneById(2);

//        $call = new Kuhni();
//
//        $call->setIdCatalog($catalogone);
//        $call->setIdKuhniStyle($styleone);
//        $call->setIdKuhniMaterial($materialone);
//        $call->setIdKuhniColor($colorone);
//        $call->setIdKuhniConfig($configone);
//        $call->setFasadColors($fasadeOne);
//        $call->addFasadColors($fasadeTwo);
//
//        $call->setName('art');
//        $call->setTitle('art');
//        $call->setDescription('art');
//        $call->setKeywords('art');
//        $call->setMainDescription('art');
//        $call->setImageName('art');
//        $call->setImageSize(1024);
//        $call->setUpdated(new \DateTime());
//        $call->setSlug('art_1_2');
//        $call->setPrice(10000);
//        $call->setDiscount(10);
//        $call->setFixedPrice(1);
//        $call->setRazmer('100x100');
//        $call->setNameFasad('Акрил Како, Акрил Винил');
//        $call->setMatFasad('Акрил');
//        $call->setStoleshnica('Бежевый гранит 38мм');
//        $call->setKorpus('ЛДСП Негро 18мм');
//        $call->setFurnitura('Hettich, Blum, FGV');
//        $call->setLikes(2);
//        $call->setCountProjects(2);
//        $call->setNoDiscountPrice(11000);
//        $entityManager->persist($call);
//        $entityManager->flush();

        return $this->render('homepage/index.html.twig', array(
            'catalog' => $result,
            'image' => $image,
            'maps' => $this->getMapLocate(),
            'formRequestCallModal' => $this->getRequestCallForm(),
            'formRequestCall' => $this->getRequestCallForm(),
            'formCostProject' => $this->getCostProject(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'form' => $this->getCallBackForm(),
            'reviews' => $this->getReviews(),
            'formReview' => $this->getReviewForm()
        ));
    }

    private function getReviews()
    {
        $reviews = $this->getDoctrine()->getManager()->getRepository('KuhniBundle:Reviews')
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.created', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        return $reviews;
    }

    private function getReviewForm()
    {
        $newReview = new Reviews();

        $review = $this->createFormBuilder($newReview)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('email', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ EMAIL *',
                    'class' => 'form-control',
                    'required' => false,
                ],
                'label' => false,
            ))
            ->add('message', TextareaType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ СООБЩЕНИЕ *',
                    'class' => 'form-control',
                    'required' => false,
                ],
                'label' => false,
            ))
            ->add('star', IntegerType::INTEGER, array(
                'attr' => [
                    'placeholder' => 'Количество звезд *',
                    'class' => 'form-control',
                    'required' => false,
                    'min' => 1,
                    'max' => 5
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $review;
    }

    private function getFreeDesignShagForm()
    {
        $FreeDesignShag = new DesignProjectShag();

        $formFreeDesignShag = $this->createFormBuilder($FreeDesignShag)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'data-validation-required-message' => 'Укажите ваше Имя.',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'id' => '123',
                    'data-validation-required-message' => 'Укажите ваш телефон для связи.',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('email', EmailType::class, array(
                'attr' => [
                    'placeholder' => 'Ваш EMAIL *',
                    'class' => 'form-control'
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $formFreeDesignShag;
    }

    private function getFreeProjectForm()
    {
        $freeProject = new freeDesignProject();

        $formFreeProject = $this->createFormBuilder($freeProject)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('email', EmailType::class, array(
                'attr' => [
                    'placeholder' => 'Ваш EMAIL',
                    'class' => 'form-control',
                    'required' => false,
                ],
                'label' => false,
            ))
            ->add('message', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ СООБЩЕНИЕ *',
                    'class' => 'form-control',
                ],
                'label' => false,
            ))
            ->add('imageFile', VichImageType::class, array(
                'required'      => false,
                'allow_delete'  => true,
                'download_link' => false,
                'label'         => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $formFreeProject;
    }

    private function getRequestCallForm()
    {
        $requestcall = new RequestCall();
        $formRequestCall = $this->createFormBuilder($requestcall)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'data-validation-required-message' => 'Укажите ваше Имя.',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'data-validation-required-message' => 'Укажите ваш телефон для связи.',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $formRequestCall;
    }

    private function getCallBackForm()
    {
        $callback = new CallBack();

        $form = $this->createFormBuilder($callback)
            ->add('name', TextType::class, array('attr' => ['placeholder' => 'ВАШЕ ИМЯ *', 'class' => 'form-control'], 'label' => false))
            ->add('email', EmailType::class, array('label' => false, 'attr' => ['placeholder' => 'Ваш EMAIL *', 'class' => 'form-control']))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('message', TextareaType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ваше Сообщение *',
                    'class' => 'form-control',
                    'maxlength' => '254'
                ]
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $form;
    }

    private function getCostProject()
    {
        $costProject = new CostProject();

        $formCostProject = $this->createFormBuilder($costProject)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('email', EmailType::class, array(
                'attr' => [
                    'placeholder' => 'Ваш EMAIL',
                    'class' => 'form-control',
                    'required' => false,
                ],
                'label' => false,
            ))
            ->add('message', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ СООБЩЕНИЕ *',
                    'class' => 'form-control',
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->add('imageFile', VichImageType::class, array(
                'required'      => false,
                'allow_delete'  => true,
                'download_link' => false,
                'label'         => false,
            ))
            ->getForm()->createView();

        return $formCostProject;
    }

    private function getZayavkaRazmer()
    {
        $ZayavkaRazmer = new ZayavkaRazmer();

        $formZayavkaRazmer = $this->createFormBuilder($ZayavkaRazmer)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('message', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ СООБЩЕНИЕ *',
                    'class' => 'form-control',
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $formZayavkaRazmer;
    }

    private function getDesignerAtHome()
    {
        $DesignerAtHome = new DesignerAtHome();

        $formDesignerAtHome = $this->createFormBuilder($DesignerAtHome)
            ->add('name', TextType::class, array('attr' => [
                'placeholder' => 'ВАШЕ ИМЯ *',
                'class' => 'form-control'],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('message', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ СООБЩЕНИЕ *',
                    'class' => 'form-control',
                    'required' => false,
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where(
                            $qb->expr()->notLike('u.username', ':name')
                        )
                            ->orderBy('u.title', 'ASC')
                            ->setParameter('name', 'admin');
                },
                'attr' => [
                    'data-validation-required-message' => 'Укажите ближайший салон.',
                    'class' => 'form-control',
                ],
                'choice_label' => function ($idSalon) {
                    $address = '';
                    if (!empty($idSalon->getMetroId())){
                        $address .= $idSalon->getMetroId()->getNameStation() . ' | ';
                        $this->colorStation = $idSalon->getMetroId()->getColor();
                    }else{
                        $address .= $idSalon->getGorod() . ' | ';
                    }
                    if (!empty($idSalon->getTc())){
                        $address .= $idSalon->getTc() . " ";
                    }else{
                        $address .= "Белорусские кухни ";
                    }
                    $address .= $idSalon->getAddress();
                    return $address;
                },
                'choice_attr' => function($idSalon) {
                    if ($idSalon->getGorod() == 'Москва'){
                        $class = 'metro';
                    }else{
                        $class = 'nometro';
                    }
                    return array('class' => $class, 'id' => $this->colorStation);
                },
                'label' => false,
            ))
            ->getForm()->createView();

        return $formDesignerAtHome;
    }

    private function getMapLocate()
    {
        $em = $this->getDoctrine()->getManager()
            ->getRepository('ApplicationSonataUserBundle:User');
        $qb = $em->createQueryBuilder('u');
        $locate =
            $qb->select()
            ->where(
                $qb->expr()->notLike('u.username', ':name')
            )
            ->orderBy('u.title', 'ASC')
            ->setParameter('name', 'admin');
        return $locate->getQuery()->getResult();
    }
}