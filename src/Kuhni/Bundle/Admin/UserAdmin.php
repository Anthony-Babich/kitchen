<?php

namespace Kuhni\Bundle\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends BaseUserAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

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
                'property' => 'title',
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
            ));
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);

        $datagridMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', TextType::class, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', TextType::class, array(
                'label' => 'Город'
            ))
            ->add('metroId', null, array(
                'label'    => 'Метро'
            ), 'entity', array(
                'class' => 'KuhniBundle:StationMoscow',
                'property' => 'title',
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
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->remove('impersonating')
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', TextType::class, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', TextType::class, array(
                'label' => 'Город'
            ))
            ->add('metroId.title', null, array(
                'label'    => 'Метро',
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
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                ),
                'label' => 'action'
            ));
    }
    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);

        $showMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', TextType::class, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', TextType::class, array(
                'label' => 'Город'
            ))
            ->add('metroId.title', null, array(
                'label'    => 'Метро',
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
            ));
    }
}