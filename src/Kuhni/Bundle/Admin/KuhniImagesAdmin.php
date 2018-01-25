<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class KuhniImagesAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('kuhniId.title', EntityType::class, array(
                'class' => 'KuhniBundle:Kuhni',
                'property' => 'title',
                'label' => 'Название кухни'
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
            ->add('kuhniId.title', null, array(
                'label'    => 'Название кухни'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniMassive',
                'property' => 'title',
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('kuhniId.title',  null, array(
                'label' => 'Название кухни',
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
            ->add('kuhniId.title', null, array(
                'label' => 'Название кухни',
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
            ));
    }
}