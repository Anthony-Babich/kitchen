<?php

namespace Kuhni\Bundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class KuhniMaterialAdmin extends AbstractAdmin
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
            ->add('caption', TextType::class, array(
                'label' => 'Подпись'
            ))
            ->add('idMassive', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniMassive',
                'property' => 'title',
                'label' => 'Массив'
            ))
            ->add('idMdf', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniMdf',
                'property' => 'title',
                'label' => 'МДФ'
            ))
            ->add('idPlastic', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniPlastic',
                'property' => 'title',
                'label' => 'Пластик'
            ))
            ->add('idGlass', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniGlass',
                'property' => 'title',
                'label' => 'Стекло'
            ))
            ->add('idAcryl', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniAcryl',
                'property' => 'title',
                'label' => 'Акрил'
            ))
            ->add('idDSP', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniDsp',
                'property' => 'title',
                'label' => 'ДСП'
            ))
            ->add('idShpon', EntityType::class, array(
                'class' => 'KuhniBundle:KuhniShpon',
                'property' => 'title',
                'label' => 'Шпон'
            ))
            ->add('keywords', TextType::class, array(
                'label' => 'Ключевые слова'
            ))
            ->add('slug', TextType::class)
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
            ->add('title', null, array(
                'label'    => 'Название'
            ))
            ->add('mainDescription', null, array(
                'label'    => 'Описание'
            ))
            ->add('idMassive', null, array(
                'label'    => 'Массив'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniMassive',
                'property' => 'title',
            ))
            ->add('idMdf', null, array(
                'label'    => 'МДФ'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniMdf',
                'property' => 'title',
            ))
            ->add('idPlastic', null, array(
                'label'    => 'Пластик'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniPlastic',
                'property' => 'title',
            ))
            ->add('idGlass', null, array(
                'label'    => 'Стекло'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniGlass',
                'property' => 'title',
            ))
            ->add('idAcryl', null, array(
                'label'    => 'Акрил'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniAcryl',
                'property' => 'title',
            ))
            ->add('idDSP', null, array(
                'label'    => 'ДСП'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniDsp',
                'property' => 'title',
            ))
            ->add('idShpon', null, array(
                'label'    => 'Шпон'
            ), 'entity', array(
                'class'    => 'KuhniBundle:KuhniShpon',
                'property' => 'title',
            ))
            ->add('keywords', null, array(
                'label'    => 'Ключевые слова'
            ));
    }
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array(
                'label'    => 'Название'
            ))
            ->add('mainDescription', null, array(
                'label'    => 'Описание'
            ))
            ->add('caption', null, array(
                'label' => 'Подпись'
            ))
            ->add('idMassive.title',  null, array(
                'label' => 'Массив',
            ))
            ->add('idMdf.title', null, array(
                'label'    => 'МДФ',
            ))
            ->add('idPlastic.title', null, array(
                'label'    => 'Пластик',
            ))
            ->add('idGlass.title', null, array(
                'label'    => 'Стекло',
            ))
            ->add('idAcryl.title', null, array(
                'label'    => 'Акрил',
            ))
            ->add('idDSP.title', null, array(
                'label'    => 'ДСП',
            ))
            ->add('idShpon.title', null, array(
                'label'    => 'Шпон',
            ))
            ->add('keywords', null, array(
                'label'    => 'Ключевые слова'
            ))
            ->add('imageName', null, array(
                'label' => 'Картинка',
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
                'label' => 'Название',
            ))
            ->add('mainDescription', null, array(
                'label' => 'Описание',
            ))
            ->add('idMassive.title', null, array(
                'label' => 'Массив',
            ))
            ->add('idMdf.title', null, array(
                'label' => 'МДФ',
            ))
            ->add('idPlastic.title', null, array(
                'label'    => 'Пластик',
            ))
            ->add('idGlass.title', null, array(
                'label'    => 'Стекло',
            ))
            ->add('idAcryl.title', null, array(
                'label'    => 'Акрил',
            ))
            ->add('idDSP.title', null, array(
                'label'    => 'ДСП',
            ))
            ->add('idShpon.title', null, array(
                'label'    => 'Шпон',
            ))
            ->add('keywords', null, array(
                'label' => 'Ключевые слова',
            ));
    }
}