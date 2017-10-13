<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class KuhniStyleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id', EntityType::class, array(
                'class' => 'KuhniBundle:Kuhni',
                'property' => 'title',
                'label' => 'Название кухни'
            ))
            ->add('title', TextType::class)
            ->add('keywords', TextType::class)
            ->add('mainDescription', TextType::class)
            ->add('slug', TextType::class)
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
            ->add('id', null, array(
                'label'    => 'Название кухни'
            ), 'entity', array(
                'class'    => 'KuhniBundle:Kuhni',
                'property' => 'Title',
            ))
            ->add('title')
            ->add('keywords')
            ->add('mainDescription')
            ->add('slug')
            ->add('imageName', null, array(
                'label' => 'Image',
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id.title', null, array(
                'label'    => 'Название кухни'
            ))
            ->add('title')
            ->add('keywords')
            ->add('mainDescription')
            ->add('slug')
            ->add('imageName', null, array(
                'label' => 'Image',
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
            ->add('id', null, array(
                'label'    => 'Название кухни'
            ))
            ->add('title')
            ->add('keywords')
            ->add('mainDescription')
            ->add('slug')
            ->add('imageName', null, array(
                'label' => 'Image',
            ));
    }
}