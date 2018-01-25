<?php

namespace Kuhni\Bundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Kuhni\Bundle\Entity\FormCostProject;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Vich\UploaderBundle\Form\Type\VichImageType;

trait TraitCostProject
{
    private function getCostProject()
    {
        $costProject = new FormCostProject();

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
            ->add('imageFile', VichImageType::class, array(
                'required'      => false,
                'allow_delete'  => true,
                'download_link' => false,
                'label'         => false,
            ))
            ->getForm()->createView();

        return $formCostProject;
    }
}