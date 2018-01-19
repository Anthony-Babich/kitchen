<?php

namespace Kuhni\Bundle\Form\Search;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ZovZakazType extends AbstractType
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, array(
                'attr' => [
                    'placeholder' => 'Как в договоре',
                    'class' => 'form-control'
                ],
                'label' => 'Номер договора'
            ))
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'placeholder' => 'ДД-ММ_ГГГГ',
                    'class' => 'form-control input-inline js-datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                ],
                'label' => 'Дата договора'
            ))
            ->add('idSalon', EntityType::class, array(
                'class' => 'KuhniBundle:Salon',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('u');
                    return
                        $qb->where('u.vivodSelect = 1')->andWhere('u.id <> 2')->orderBy('u.id', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'property' => 'title',
                'label' => 'Выберите ВАШ салон',
            ))
        ;
    }
    public function getDefaultOptions()
    {
        return array(
            'csrf_protection' => false,
        );
    }
    function getName()
    {
        return 'searchorg';
    }
}