<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class KuhniConfigAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class, array(
                'label' => 'Название'
            ))
            ->add('mainDescription', TextType::class, array(
                'label' => 'Описание'
            ))
            ->add('keywords', TextType::class, array(
                'label' => 'Ключевые слова'
            ))
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
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('mainDescription', null, array(
                'label' => 'Описание'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('mainDescription', null, array(
                'label' => 'Описание'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
            ))
            ->add('slug')
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
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('mainDescription', null, array(
                'label' => 'Описание'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
            ))
            ->add('slug');
    }
}