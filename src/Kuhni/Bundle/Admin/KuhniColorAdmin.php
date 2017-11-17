<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;

class KuhniColorAdmin extends AbstractAdmin
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
            ->add('color', TextType::class, array(
                'label' => 'Цвет'
            ))
            ->add('keywords', TextType::class, array(
                'label' => 'Ключевые слова'
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
            ->add('slug', TextType::class);
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
            ->add('color', null, array(
                'label' => 'Цвет'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
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
            ->add('color', null, array(
                'label' => 'Цвет'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('article', null, array(
                'label' => 'Статья'
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
            ->add('color', null, array(
                'label' => 'Цвет'
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова'
            ))
            ->add('article', null, array(
                'label' => 'Статья'
            ))
            ->add('slug');
    }
}