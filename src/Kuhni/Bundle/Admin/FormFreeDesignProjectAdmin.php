<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FormFreeDesignProjectAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class, array(
                'label' => 'Имя'
            ))
            ->add('email', TextType::class, array(
                'label' => 'EMail'
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
                'class' => 'KuhniBundle:Salon',
                'property' => 'title',
            ))
            ->add('updated', DateTimeType::class, array(
                'label' => 'Время заказа'
            ))
            ->add('imageFile', VichImageType::class, array(
                'required'      => false,
                'allow_delete'  => true,
                'download_link' => false,
            ));
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                'label' => 'Имя'
            ))
            ->add('email', null, array(
                'label' => 'EMail'
            ))
            ->add('phone', null, array(
                'label' => 'Телефон'
            ))
            ->add('idSalon', null, array(
                'label'    => 'Салон'
            ), 'entity', array(
                'class'    => 'KuhniBundle:Salon',
                'property' => 'title',
            ))
            ->add('updated', null, array(
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
            ->add('email', null, array(
                'label' => 'EMail'
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
            ->add('updated', null, array(
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
            ->add('email', null, array(
                'label' => 'EMail'
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
            ->add('updated', null, array(
                'label' => 'Время заказа'
            ));
    }
}