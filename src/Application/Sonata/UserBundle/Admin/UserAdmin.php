<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends BaseUserAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', TextType::class, array(
                'label' => 'Имя пользователя'
            ))
            ->add('usernameCanonical', TextType::class, array(
                'label' => 'Имя пользователя каноничное'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'e-mail'
            ))
            ->add('emailCanonical', EmailType::class, array(
                'label' => 'e-mail каноничное'
            ))
            ->add('roles', TextType::class, array(
                'label' => 'Роли'
            ))
            ->add('salt', TextType::class, array(
                'label' => 'Salt'
            ))
            ->add('password', TextType::class, array(
                'label' => 'Пароль'
            ))
            ->add('title', TextType::class, array(
                'label' => 'Название'
            ))
            ->add('tc', TextType::class, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', TextType::class, array(
                'label' => 'Город'
            ))
            ->add('metroId', EntityType::class, array(
                'class' => 'KuhniBundle:StationMoscow',
                'property' => 'nameStation',
                'label' => 'Метро'
            ))
            ->add('description', TextType::class, array(
                'label' => 'Описание'
            ))
            ->add('address', TextType::class, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', TextType::class, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', TextType::class, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', TextType::class, array(
                'label' => 'Время работы'
            ))
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
            ->add('salt', null, array(
                'label' => 'Salt'
            ))
            ->add('password', null, array(
                'label' => 'Пароль'
            ))
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('metroId', null, array(
                'class' => 'KuhniBundle:StationMoscow',
                'property' => 'nameStation',
                'label' => 'Метро'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('address', null, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', null, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', null, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
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
            ->add('salt', null, array(
                'label' => 'Salt'
            ))
            ->add('password', null, array(
                'label' => 'Пароль'
            ))
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('metroId.nameStation', null, array(
                'label' => 'Метро'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('address', null, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', null, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', null, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
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
            ->add('salt', null, array(
                'label' => 'Salt'
            ))
            ->add('password', null, array(
                'label' => 'Пароль'
            ))
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('metroId.nameStation', null, array(
                'label' => 'Метро'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('address', null, array(
                'label' => 'Адресс'
            ))
            ->add('longitude', null, array(
                'label' => 'Долгота'
            ))
            ->add('latitude', null, array(
                'label' => 'Широта'
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
            ))
        ;
    }
}
