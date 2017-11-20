<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SalonAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class, array(
                'label' => 'Название'
            ))
            ->add('tc', TextType::class, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', TextType::class, array(
                'label' => 'Город'
            ))
            ->add('metroId', EntityType::class, array(
                'class' => 'KuhniBundle:StationMoscow',
                'property' => 'nameStation',
                'label' => 'Метро'
            ))
            ->add('description', TextType::class, array(
                'label' => 'Описание'
            ))
            ->add('address', TextType::class, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', TextType::class, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', TextType::class, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', TextType::class, array(
                'label' => 'Время работы'
            ))
            ->add('vivodKarta', ChoiceType::class, array(
                'label' => 'Вывод на карту',
                'choices' => [
                    'Не выводить' => '0',
                    'Выводить' => '1'
                ],
            ))
            ->add('vivodSelect', ChoiceType::class, array(
                'label' => 'Вывод в select',
                'choices' => [
                    'Не выводить' => '0',
                    'Выводить' => '1'
                ],
            ))
            ->add('idUser', EntityType::class, array(
                'class' => 'ApplicationSonataUserBundle:User',
                'property' => 'username',
                'label' => 'Салон пользователя'
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('metroId', null, array(
                'class' => 'KuhniBundle:StationMoscow',
                'property' => 'nameStation',
                'label' => 'Метро'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('address', null, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', null, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', null, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
            ))
            ->add('vivodKarta', null, array(
                'label' => 'Вывод на карту',
            ))
            ->add('vivodSelect', null, array(
                'label' => 'Вывод в select',
            ))
            ->add('idUser', null, array(
                'label' => 'Салон пользователя'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('metroId.nameStation', null, array(
                'label' => 'Метро'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('address', null, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', null, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', null, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
            ))
            ->add('vivodKarta', null, array(
                'label' => 'Вывод на карту',
            ))
            ->add('vivodSelect', null, array(
                'label' => 'Вывод в select',
            ))
            ->add('idUser.username', null, array(
                'label' => 'Салон пользователя'
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                ),
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('vivodKarta', null, array(
                'label' => 'Вывод на карту',
            ))
            ->add('vivodSelect', null, array(
                'label' => 'Вывод в select',
            ))
            ->add('metroId.nameStation', null, array(
                'label' => 'Метро'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('address', null, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', null, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', null, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
            ))
            ->add('idUser.username', null, array(
                'label' => 'Салон пользователя'
            ))
        ;
    }
}