<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends BaseUserAdmin
{
    public function preUpdate($user)
    {
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Описание', array('class' => 'col-xs-6'))
                ->add('username', TextType::class, array(
                    'label' => 'Имя пользователя'
                ))
                ->add('email', EmailType::class, array(
                    'label' => 'e-mail'
                ))
                ->add('salt', TextType::class, array(
                    'label' => 'Salt'
                ))
                ->add('password', TextType::class, array(
                    'label' => 'Пароль'
                ))
            ->end()
            ->with('Салоны', array('class' => 'col-xs-6'))
                ->add('salons', 'sonata_type_model', array(
                    'class' => 'KuhniBundle:Salon',
                    'property' => 'title',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'label' => false
                ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username', null, array(
                'label' => 'Имя пользователя'
            ))
            ->add('email', null, array(
                'label' => 'e-mail'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username', null, array(
                'label' => 'Имя пользователя'
            ))
            ->add('email', null, array(
                'label' => 'e-mail'
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                ),
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username', null, array(
                'label' => 'Имя пользователя'
            ))
            ->add('email', null, array(
                'label' => 'e-mail'
            ))
        ;
    }
}
