<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SalonImagesAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('salonId', EntityType::class, array(
                'class' => 'KuhniBundle:Salon',
                'property' => 'title',
                'label' => false
            ))
            ->add('title', TextType::class, array(
                'label' => 'Описание'
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
            ->add('salonId', null, array(
                'label' => 'Название салона'
            ), 'entity', array(
                'class' => 'KuhniBundle:Salon',
                'property' => 'title',
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('salonId.title', null, array(
                'label' => 'Название салона'
            ))
            ->add('title', null, array(
                'label' => 'Описание'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
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
            ->add('salonId.title', null, array(
                'label' => 'Название салона'
            ))
            ->add('title', null, array(
                'label' => 'Описание'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
            ));
    }
}