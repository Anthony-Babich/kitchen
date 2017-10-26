<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CatalogAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class, array(
                'label' => 'Название'
            ))
            ->add('title', TextType::class, array(
                'label' => 'Заглавие'
            ))
            ->add('description', TextType::class, array(
                'label' => 'Описание'
            ))
            ->add('keywords', TextType::class, array(
                'label' => 'Ключевые слова'
            ))
            ->add('alt', TextType::class, array(
                'label' => 'Описание картинки'
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
            ->add('name', null , array(
                'label' => 'Название'
            ))
            ->add('title', null, array(
                'label' => 'Заглавие'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array(
                'label' => 'Название'
            ))
            ->add('title', null, array(
                'label' => 'Заглавие'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('alt', null, array(
                'label' => 'Описание картинки'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка'
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
                'label' => 'Название'
            ))
            ->add('title', null, array(
                'label' => 'Заглавие'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('alt', null, array(
                'label' => 'Описание картинки'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка'
            ));
    }
}