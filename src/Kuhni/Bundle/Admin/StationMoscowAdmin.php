<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;

class StationMoscowAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nameStation', TextType::class, array(
                'label' => 'Название станции'
            ))
            ->add('line', TextType::class, array(
                'label' => 'Название линии'
            ))
            ->add('color', TextType::class, array(
                'label' => 'Цвет'
            ));
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nameStation', null, array(
                'label' => 'Название станции'
            ))
            ->add('line', null, array(
                'label' => 'Название линии'
            ))
            ->add('color', null, array(
                'label' => 'Цвет'
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nameStation', null, array(
                'label' => 'Название станции'
            ))
            ->add('line', null, array(
                'label' => 'Название линии'
            ))
            ->add('color', null, array(
                'label' => 'Цвет'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ));
    }
    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nameStation', null, array(
                'label' => 'Название станции'
            ))
            ->add('line', null, array(
                'label' => 'Название линии'
            ))
            ->add('color', null, array(
                'label' => 'Цвет'
            ))
            ->add('slug');
    }
}