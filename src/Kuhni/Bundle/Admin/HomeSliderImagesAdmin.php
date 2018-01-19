<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class HomeSliderImagesAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Описание', array('class' => 'col-xs-12 col-md-6'))
                ->add('title', TextType::class, array(
                    'label' => 'Описание для иконок',
                    'required' => true,
                ))
                ->add('link', TextType::class, array(
                    'label' => 'Адрес, на который отправляет слайдер',
                    'required' => true,
                    'attr' => [
                        'title' => 'Вызов дизайнера на дом - designerAtHome
Заявка на бесплатный расчет проекта - zayavkaRazmer
Связаться с нами - contactmodal
Заявка на бесплатный дизайн-проект - freedesignproject
Закажите обратный звонок - requestcall',
                    ],
                ))
                ->add('priority', IntegerType::class, array(
                    'label' => 'Приоритет',
                    'attr' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'required' => true,
                ))
                ->add('output', ChoiceType::class, array(
                    'label' => 'Вывод слайдера',
                    'choices' => [
                        0 => 'Не выводить слайдер',
                        1 => 'Вывести слайдер',
                    ],
                    'required' => true,
                ))
                ->add('modal', ChoiceType::class, array(
                    'label' => 'Переход на модальное окно',
                    'choices' => [
                        0 => 'Нет',
                        1 => 'Да',
                    ],
                    'required' => true,
                ))
            ->end()
            ->with('Характеристики', array('class' => 'col-xs-12 col-md-6'))
                ->add('imageFileIconNoHover', VichImageType::class, array(
                    'required'      => false,
                    'allow_delete'  => true,
                    'download_link' => false,
                    'label'         => 'Иконка без наведения (black)',
                ))
                ->add('imageFileIconOnHover', VichImageType::class, array(
                    'required'      => false,
                    'allow_delete'  => true,
                    'download_link' => false,
                    'label'         => 'Иконка с наведением (white)',
                ))
                ->add('imageFileBannerPC', VichImageType::class, array(
                    'required'      => false,
                    'allow_delete'  => true,
                    'download_link' => false,
                    'label'         => 'Баннер для полной версии сайта',
                ))
                ->add('imageFileBannerMobile', VichImageType::class, array(
                    'required'      => false,
                    'allow_delete'  => true,
                    'download_link' => false,
                    'label'         => 'Баннер для мобильной версии сайта',
                ))
            ->end();
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array(
                'label' => 'Описание для иконок',
            ))
            ->add('link', null, array(
                'label' => 'Адрес, на который отправляет слайдер',
            ))
            ->add('output', null, array(
                'label' => 'Вывод слайдера',
            ))
            ->add('modal', null, array(
                'label' => 'Переход на модальное окно',
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array(
                'label' => 'Описание для иконок',
            ))
            ->add('link', null, array(
                'label' => 'Адрес, на который отправляет слайдер',
            ))
            ->add('priority', null, array(
                'label' => 'Приоритет',
            ))
            ->add('output', null, array(
                'label' => 'Вывод слайдера',
            ))
            ->add('modal', null, array(
                'label' => 'Переход на модальное окно',
            ))
            ->add('imageNameIconNoHover', null, array(
                'label' => 'Иконка без наведения (black)',
            ))
            ->add('imageNameIconOnHover', null, array(
                'label' => 'Иконка с наведением (white)',
            ))
            ->add('imageNameBannerPC', null, array(
                'label' => 'Баннер для полной версии сайта',
            ))
            ->add('imageNameBannerMobile', null, array(
                'label' => 'Баннер для мобильной версии сайта',
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
                'label' => 'Описание для иконок',
            ))
            ->add('link', null, array(
                'label' => 'Адрес, на который отправляет слайдер',
            ))
            ->add('priority', null, array(
                'label' => 'Приоритет',
            ))
            ->add('output', null, array(
                'label' => 'Вывод слайдера',
            ))
            ->add('modal', null, array(
                'label' => 'Переход на модальное окно',
            ))
            ->add('imageNameIconNoHover', null, array(
                'label' => 'Иконка без наведения (black)',
            ))
            ->add('imageNameIconOnHover', null, array(
                'label' => 'Иконка с наведением (white)',
            ))
            ->add('imageNameBannerPC', null, array(
                'label' => 'Баннер для полной версии сайта',
            ))
            ->add('imageNameBannerMobile', null, array(
                'label' => 'Баннер для мобильной версии сайта',
            ));
    }
}