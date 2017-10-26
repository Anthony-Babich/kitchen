<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FasadTypeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class, array(
                'label' => 'Заглавие'
            ))
            ->add('name', TextType::class, array(
                'label' => 'Название'
            ))
            ->add('alt', TextType::class, array(
                'label' => 'Описание'
            ))
            ->add('idKuhniMaterial', EntityType::class, array(
                'label' => 'Название материала кухни',
                'class' => 'KuhniBundle:KuhniMaterial',
                'property' => 'title',
            ))
            ->add('imageFile', VichImageType::class, array(
                'label'         => 'Картинка',
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
                'label' => 'Название',
            ))
            ->add('idKuhniMaterial', null, array(
                'label'    => 'Название материала кухни'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniMaterial',
                'property' => 'title',
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array(
                'label' => 'Заглавие'
            ))
            ->add('name', null, array(
                'label' => 'Название'
            ))
            ->add('alt', null, array(
                'label' => 'Описание'
            ))
            ->add('idKuhniMaterial.title', null, array(
                'label' => 'Название материала кухни',
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
            ->add('title', null, array(
                'label' => 'Заглавие'
            ))
            ->add('name', null, array(
                'label' => 'Название'
            ))
            ->add('alt', null, array(
                'label' => 'Описание'
            ))
            ->add('idKuhniMaterial.title', null, array(
                'label' => 'Название материала кухни',
            ));
    }
}