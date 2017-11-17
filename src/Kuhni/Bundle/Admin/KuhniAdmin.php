<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                ->with('Описание', array('class' => 'col-xs-12 col-md-6'))
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
                    ->add('discount', MoneyType::class, array(
                        'label' => 'Скидка'
                    ))
                    ->add('likes', NumberType::class, array(
                        'label' => 'Лайки'
                    ))
                    ->add('countProjects', NumberType::class, array(
                        'label' => 'Количество выполненных проектов'
                    ))
                    ->add('fixedPrice', ChoiceType::class, array(
                        'label' => 'Фиксированная стоимость',
                        'choices' => [
                            'Цену и наличие уточняйте' => '1',
                            'Цена указана за 1 метр погонный кухни в стандартной комплектации' => '0'
                        ],
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
                    ->add('article', 'genemu_tinymce', array(
                        'label' => 'Статья',
                        'configs' => array(
                            'add_unload_trigger' => 'false',
                            'remove_linebreaks' => 'true',
                            'inline_styles' => 'true',
                            'convert_fonts_to_spans' => 'true',
                            'elements' => "content_editor",
                            'plugins' => "autolink,lists,spellchecker,pagebreak,table,preview,save,insertdatetime,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking",
                            'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
                            'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,uploads_image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                            'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                            'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,blockquote,pagebreak,|,insertfile,insertimage",
                            'theme_advanced_toolbar_location' => "top",
                            'theme_advanced_toolbar_align' => "left",
                            'theme_advanced_statusbar_location' => "bottom",
                            'theme_advanced_resizing' => true,
                        )
                    ))
                ->end()
                ->with('Характеристики', array('class' => 'col-xs-12 col-md-6'))
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
            ->tab('Фасады и цвета')
                ->with('Цвета фасадов', array('class' => 'col-12 col-md-4'))
                    ->add('fasadColors', 'sonata_type_model', array(
                        'class' => 'KuhniBundle:FasadColor',
                        'property' => 'title',
                        'multiple' => true,
                        'expanded' => true,
                        'required' => false,
                        'label' => false
                    ))
                ->end()
                ->with('Типы фасадов', array('class' => 'col-12 col-md-4'))
                    ->add('fasadTypes', 'sonata_type_model', array(
                        'class' => 'KuhniBundle:FasadType',
                        'property' => 'title',
                        'multiple' => true,
                        'expanded' => true,
                        'required' => false,
                        'label' => false
                    ))
                ->end()
                ->with('Цвета', array('class' => 'col-12 col-md-2'))
                    ->add('kuhniColors', 'sonata_type_model', array(
                        'class' => 'KuhniBundle:KuhniColor',
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
            ->add('likes', null, array(
             'label' => 'Лайки'
            ))
            ->add('countProjects', null, array(
             'label' => 'Количество выполненных проектов'
            ))
            ->add('fixedPrice', null, array(
            'label' => 'Фиксированная стоимость'
            ))
            ->add('article', null, array(
                'label' => 'Статья'
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
            ->add('article', null, array(
                'label' => 'Статья'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
            ));
    }
}