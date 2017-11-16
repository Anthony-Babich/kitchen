<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;

class PromoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class, array(
                'label' => 'Имя'
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Телефон'
            ))
            ->add('email', TextType::class, array(
                'label' => 'Email'
            ))
            ->add('gorod', TextType::class, array(
                'label' => 'Город'
            ))
            ->add('discount', TextType::class, array(
                'label' => 'Скидка'
            ))
            ->add('url', TextType::class, array(
                'label' => 'Откуда пришли'
            ))
            ->add('geoIP', TextType::class, array(
                'label' => 'IP-адресс'
            ));
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                'label' => 'Имя'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('discount', null, array(
                'label' => 'Скидка'
            ))
            ->add('url', null, array(
                'label' => 'Откуда пришли'
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array(
                'label' => 'Имя'
            ))
            ->add('phone', null, array(
                'label' => 'Телефон'
            ))
            ->add('email', null, array(
                'label' => 'Email'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('discount', null, array(
                'label' => 'Скидка'
            ))
            ->add('url', null, array(
                'label' => 'Откуда пришли'
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
            ->add('name', null, array(
                'label' => 'Имя'
            ))
            ->add('phone', null, array(
                'label' => 'Телефон'
            ))
            ->add('email', null, array(
                'label' => 'Email'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('discount', null, array(
                'label' => 'Скидка'
            ))
            ->add('url', null, array(
                'label' => 'Откуда пришли'
            ));
    }
}