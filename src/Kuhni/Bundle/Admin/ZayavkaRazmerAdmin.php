<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Sonata\AdminBundle\Show\ShowMapper;

class ZayavkaRazmerAdmin extends AbstractAdmin
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
            ->add('message', TextType::class, array(
                'label' => 'Сообщение'
            ))
            ->add('url', TextType::class, array(
                'label' => 'Откуда пришли'
            ))
            ->add('geoIP', TextType::class, array(
                'label' => 'IP-адресс'
            ))
            ->add('idSalon', EntityType::class, array(
                'label' => 'Салон',
                'class' => 'ApplicationSonataUserBundle:User',
                'property' => 'title',
            ))
            ->add('created', DateTimeType::class, array(
                'label' => 'Время заказа'
            ));
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                'label' => 'Имя'
            ))
            ->add('phone', null, array(
                'label' => 'Телефон'
            ))
            ->add('idSalon', null, array(
                'label'    => 'Салон'
            ), 'entity', array(
                'class'    => 'ApplicationSonataUserBundle:User',
                'property' => 'title',
            ))
            ->add('created', null, array(
                'label' => 'Время заказа'
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
            ->add('message', null, array(
                'label' => 'Сообщение'
            ))
            ->add('idSalon.title', null, array(
                'label'    => 'Салон'
            ))
            ->add('url', null, array(
                'label' => 'Откуда пришли'
            ))
            ->add('geoIP', null, array(
                'label' => 'IP-адресс'
            ))
            ->add('created', null, array(
                'label' => 'Время заказа'
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
            ->add('message', TextType::class, array(
                'label' => 'Сообщение'
            ))
            ->add('idSalon.title', null, array(
                'label'    => 'Салон'
            ))
            ->add('url', null, array(
                'label' => 'Откуда пришли'
            ))
            ->add('geoIP', null, array(
                'label' => 'IP-адресс'
            ))
            ->add('created', null, array(
                'label' => 'Время заказа'
            ));
    }
}