<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Sonata\AdminBundle\Show\ShowMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class KuhniAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Основаные параметры')
                ->with('Описание', array('class' => 'col-12 col-md-6'))
                    ->add('name', TextType::class, array(
                        'label' => 'Название'
                    ))
                    ->add('title', TextType::class, array(
                        'label' => 'Заглавие'
                    ))
                    ->add('description', TextType::class, array(
                        'label' => 'Описание'
                    ))
                    ->add('price', MoneyType::class, array(
                        'label' => 'Цена'
                    ))
                    ->add('idCatalog', EntityType::class, array(
                        'class' => 'KuhniBundle:Catalog',
                        'property' => 'title',
                        'label' => 'Каталог'
                    ))
                    ->add('idKuhniStyle', EntityType::class, array(
                        'class' => 'KuhniBundle:KuhniStyle',
                        'property' => 'title',
                        'label' => 'Стиль'
                    ))
                    ->add('idKuhniMaterial', EntityType::class, array(
                        'class' => 'KuhniBundle:KuhniMaterial',
                        'property' => 'title',
                        'label' => 'Материал'
                    ))
                    ->add('idKuhniConfig', EntityType::class, array(
                        'class' => 'KuhniBundle:KuhniConfig',
                        'property' => 'title',
                        'label' => 'Конфигурация'
                    ))
                    ->add('idKuhniColor', EntityType::class, array(
                        'class' => 'KuhniBundle:KuhniColor',
                        'property' => 'title',
                        'label' => 'Цвет'
                    ))
                    ->add('discount', MoneyType::class, array(
                        'label' => 'Скидка'
                    ))
                    ->add('likes', NumberType::class, array(
                        'label' => 'Лайки'
                    ))
                    ->add('countProjects', NumberType::class, array(
                        'label' => 'Количество выполненных проектов'
                    ))
                    ->add('fixedPrice', TextType::class, array(
                        'label' => 'Фиксированная стоимость'
                    ))
                    ->add('keywords', TextType::class, array(
                        'label' => 'Ключевые слова'
                    ))
                    ->add('mainDescription', TextType::class, array(
                        'label' => 'Описание'
                    ))
                    ->add('slug', TextType::class, array(
                        'label' => 'slug'
                    ))
                    ->add('imageFile', VichImageType::class, array(
                        'required'      => false,
                        'allow_delete'  => true,
                        'download_link' => false,
                        'label'         => 'Картинка',
                    ))
                ->end()
                ->with('Характеристики', array('class' => 'col-12 col-md-6'))
                    ->add('razmer', TextType::class, array(
                        'label' => 'Размер'
                    ))
                    ->add('nameFasad', TextType::class, array(
                        'label' => 'Название фасада'
                    ))
                    ->add('matFasad', TextType::class, array(
                        'label' => 'Материал фасада'
                    ))
                    ->add('stoleshnica', TextType::class, array(
                        'label' => 'Столешница'
                    ))
                    ->add('korpus', TextType::class, array(
                        'label' => 'Корпус'
                    ))
                    ->add('furnitura', TextType::class, array(
                        'label' => 'Фурнитура'
                    ))
                ->end()
            ->end()
            ->tab('Фасады')
                ->with('Цвета фасадов', array('class' => 'col-12 col-md-6'))
                    ->add('fasadColors', 'sonata_type_model', array(
                        'class' => 'KuhniBundle:FasadColor',
                        'property' => 'title',
                        'multiple' => true,
                        'expanded' => true,
                        'required' => false,
                        'label' => false
                    ))
                ->end()
                ->with('Типы фасадов', array('class' => 'col-12 col-md-6'))
                    ->add('fasadTypes', 'sonata_type_model', array(
                        'class' => 'KuhniBundle:FasadType',
                        'property' => 'title',
                        'multiple' => true,
                        'expanded' => true,
                        'required' => false,
                        'label' => false
                    ))
                ->end()
            ->end()
        ;
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('price', null, array(
                'label' => 'Цена'
            ))
            ->add('idKuhniStyle', null, array(
                'label'    => 'Стиль'
            ), 'entity', array(
                'class' => 'KuhniBundle:KuhniStyle',
                'property' => 'title',
            ))
            ->add('idKuhniMaterial', null, array(
                'label'    => 'Материал'
            ), 'entity', array(
                'class' => 'KuhniBundle:KuhniMaterial',
                'property' => 'title',
            ))
            ->add('idKuhniConfig', null, array(
                'label'    => 'Конфигурация'
            ), 'entity', array(
                'class' => 'KuhniBundle:KuhniConfig',
                'property' => 'title',
            ))
            ->add('idKuhniColor', null, array(
                'label'    => 'Цвет'
            ), 'entity', array(
                'class' => 'KuhniBundle:KuhniColor',
                'property' => 'title',
            ))
            ->add('likes', null, array(
                'label' => 'Лайки'
            ))
            ->add('countProjects', null, array(
                'label' => 'Количество выполненных проектов'
            ))
            ->add('fixedPrice', null, array(
                'label' => 'Фиксированная стоимость'
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('price', null, array(
                'label' => 'Цена'
            ))
            ->add('idKuhniStyle.title', null, array(
             'label'    => 'Стиль',
            ))
            ->add('idKuhniMaterial.title', null, array(
             'label'    => 'Материал'
            ))
            ->add('idKuhniConfig.title', null, array(
             'label'    => 'Конфигурация'
            ))
            ->add('idKuhniColor.title', null, array(
             'label'    => 'Цвет'
            ))
            ->add('likes', null, array(
             'label' => 'Лайки'
            ))
            ->add('countProjects', null, array(
             'label' => 'Количество выполненных проектов'
            ))
            ->add('fixedPrice', null, array(
            'label' => 'Фиксированная стоимость'
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
                'label' => 'Название'
            ))
            ->add('title', null, array(
                'label' => 'Заглавие'
            ))
            ->add('description', null, array(
                'label' => 'Описание'
            ))
            ->add('price', null, array(
                'label' => 'Цена'
            ))
            ->add('idKuhniStyle.title', null, array(
                'label' => 'Стиль'
            ))
            ->add('idKuhniMaterial.title', null, array(
                'label' => 'Материал'
            ))
            ->add('idKuhniConfig.title', null, array(
                'label' => 'Конфигурация'
            ))
            ->add('idKuhniColor.title', null, array(
                'label' => 'Цвет'
            ))
             ->add('discount', null, array(
                 'label' => 'Скидка'
             ))
             ->add('likes', null, array(
                 'label' => 'Лайки'
             ))
            ->add('countProjects', null, array(
                   'label' => 'Количество выполненных проектов'
               ))
            ->add('fixedPrice', null, array(
               'label' => 'Фиксированная стоимость'
           ))
           ->add('razmer', null, array(
               'label' => 'Размер'
           ))
           ->add('nameFasad', null, array(
               'label' => 'Название фасада'
           ))
           ->add('matFasad', null, array(
               'label' => 'Материал фасада'
           ))
           ->add('stoleshnica', null, array(
               'label' => 'Столешница'
           ))
           ->add('korpus', null, array(
               'label' => 'Корпус'
           ))
           ->add('furnitura', null, array(
               'label' => 'Фурнитура'
           ))
           ->add('keywords', null, array(
               'label' => 'Ключевые слова'
           ))
           ->add('mainDescription', null, array(
               'label' => 'Описание'
           ))
           ->add('imageName', null, array(
               'label' => 'Картинка',
           ));
    }
}