<?php

namespace Kuhni\Bundle\Controller;

use Kuhni\Bundle\Entity\CallBack;
use Kuhni\Bundle\Entity\CostProject;
use Kuhni\Bundle\Entity\DesignerAtHome;
use Kuhni\Bundle\Entity\DesignProjectShag;
use Kuhni\Bundle\Entity\freeDesignProject;
use Kuhni\Bundle\Entity\RequestCall;
use Kuhni\Bundle\Entity\ZayavkaRazmer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SalonController extends Controller
{
    private $colorStation;

    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($slug){




        return $this->render('salon/index.html.twig', array(
            'maps' => $this->getMapLocate(),
            'formRequestCallModal' => $this->getRequestCallForm(),
            'formRequestCall' => $this->getRequestCallForm(),
            'formCostProject' => $this->getCostProject(),
            'formFreeDesignShag' => $this->getFreeDesignShagForm(),
            'formFreeProject' => $this->getFreeProjectForm(),
            'formZayavkaRazmer' => $this->getZayavkaRazmer(),
            'formDesignerAtHome' => $this->getDesignerAtHome(),
            'form' => $this->getCallBackForm(),
        ));
    }

    private function getMapLocate()
    {
        $em = $this->getDoctrine()->getManager()
            ->getRepository('KuhniBundle:Salon');
        $qb = $em->createQueryBuilder('u');
        $locate =
            $qb->where('u.vivodKarta = 1')->orderBy('u.id', 'ASC');
        return $locate->getQuery()->getResult();
    }

    private function getRequestCallForm()
    {
        $requestcall = new RequestCall();
        $formRequestCall = $this->createFormBuilder($requestcall)
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни»  ";
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

    private function getFreeDesignShagForm()
    {
        $FreeDesignShag = new DesignProjectShag();

        $formFreeDesignShag = $this->createFormBuilder($FreeDesignShag)
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'id' => '123',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
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
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни»  ";
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
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('email', EmailType::class, array(
                'attr' => [
                    'placeholder' => 'Ваш EMAIL',
                    'class' => 'form-control',
                ],
                'required' => false,
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
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни»  ";
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

    private function getCostProject()
    {
        $costProject = new CostProject();

        $formCostProject = $this->createFormBuilder($costProject)
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
                    'class' => 'form-control',
                    'type' => 'tel',
                ],
                'label' => false,
            ))
            ->add('email', EmailType::class, array(
                'attr' => [
                    'placeholder' => 'Ваш EMAIL',
                    'class' => 'form-control',
                ],
                'required' => false,
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
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни»  ";
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

    private function getCallBackForm()
    {
        $callback = new CallBack();

        $form = $this->createFormBuilder($callback)
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ваш EMAIL *',
                    'class' => 'form-control'
                ]
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
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
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни»  ";
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

    private function getZayavkaRazmer()
    {
        $ZayavkaRazmer = new ZayavkaRazmer();

        $formZayavkaRazmer = $this->createFormBuilder($ZayavkaRazmer)
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
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
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни»  ";
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
            ->add('name', TextType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШЕ ИМЯ *',
                    'pattern' => '^[А-Яа-яЁё\s]{3,}',
                    'title' => 'Имя на Русском',
                    'class' => 'form-control'
                ],
                'label' => false
            ))
            ->add('phone', NumberType::class, array(
                'attr' => [
                    'placeholder' => 'ВАШ ТЕЛЕФОН *',
                    'pattern' => '[\+][7]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}',
                    'title' => 'Телефон в формате +71234567890',
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
                'required' => false,
                'label' => false,
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->orderBy('u.id', 'ASC');
                },
                'attr' => [
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
                        $address .= "«Белорусские кухни» ";
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
}