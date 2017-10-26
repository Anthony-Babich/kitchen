<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('address', TextType::class)
            ->add('longitude', TextType::class)
            ->add('latitude', TextType::class)
            ->add('workingHours', TextType::class);
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('title')
            ->add('description')
            ->add('address')
            ->add('longitude')
            ->add('latitude')
            ->add('workingHours');
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('title')
            ->add('description')
            ->add('address')
            ->add('longitude')
            ->add('latitude')
            ->add('workingHours')
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
            ->add('username')
            ->add('email')
            ->add('title')
            ->add('description')
            ->add('address')
            ->add('longitude')
            ->add('latitude')
            ->add('workingHours');
    }
}