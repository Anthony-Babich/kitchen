<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SalonAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Описание', array('class' => 'col-xs-12 col-md-6'))
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
                ->add('slug', TextType::class, array(
                    'label' => 'Уникальное краткое название салона на англ. яз'
                ))
                ->add('slugAddress', TextType::class, array(
                    'label' => 'Уникальное краткое название города на англ. яз'
                ))
                ->add('vivodKarta', ChoiceType::class, array(
                    'label' => 'Вывод на карту',
                    'choices' => [
                        '0' => 'Не выводить',
                        '1' => 'Выводить'
                    ],
                ))
                ->add('vivodSelect', ChoiceType::class, array(
                    'label' => 'Вывод в select',
                    'choices' => [
                        '0' => 'Не выводить',
                        '1' => 'Выводить'
                    ],
                ))
                ->add('idUser', EntityType::class, array(
                    'class' => 'ApplicationSonataUserBundle:User',
                    'property' => 'username',
                    'label' => 'Салон пользователя'
                ))
            ->end()
            ->with('Картинка и статья', array('class' => 'col-xs-12 col-md-6'))
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
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
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
            ->add('vivodKarta', null, array(
                'label' => 'Вывод на карту',
            ))
            ->add('vivodSelect', null, array(
                'label' => 'Вывод в select',
            ))
            ->add('article', null, array(
                'label' => 'Статья',
            ))
            ->add('idUser', null, array(
                'label'    => 'Салон пользователя'
            ), 'entity', array(
                'class' => 'ApplicationSonataUserBundle:User',
                'property' => 'username',
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
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
            ->add('vivodKarta', null, array(
                'label' => 'Вывод на карту',
            ))
            ->add('vivodSelect', null, array(
                'label' => 'Вывод в select',
            ))
            ->add('article', null, array(
                'label' => 'Статья',
            ))
            ->add('idUser.username', null, array(
                'label' => 'Салон пользователя'
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
            ->add('title', null, array(
                'label' => 'Название'
            ))
            ->add('tc', null, array(
                'label' => 'Торговый центр'
            ))
            ->add('gorod', null, array(
                'label' => 'Город'
            ))
            ->add('vivodKarta', null, array(
                'label' => 'Вывод на карту',
            ))
            ->add('vivodSelect', null, array(
                'label' => 'Вывод в select',
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
            ->add('article', null, array(
                'label' => 'Статья',
            ))
            ->add('workingHours', null, array(
                'label' => 'Время работы'
            ))
            ->add('idUser.username', null, array(
                'label' => 'Салон пользователя'
            ))
        ;
    }
}