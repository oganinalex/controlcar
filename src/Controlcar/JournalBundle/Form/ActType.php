<?php

namespace Controlcar\JournalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                'label' => 'Номер акта'
                ))
            ->add('date', 'date', array(
               'input'  => 'datetime',
               'widget' => 'single_text'
               ))
            ->add('car', 'entity', array(
               'class' => 'ControlcarJournalBundle:Car',
               'property' => 'name'
               ))
            ->add('weight', 'integer')
            ->add('transposition', 'entity', array(
                 'class' => 'ControlcarJournalBundle:Transposition',
                 'property' => 'name',
                 'expanded' => true,
                 'attr' => array(
                    //'class' => 'hide'
                    )
                 ))
            ->add('distance', 'integer')
            ->add('price_by_km', 'money')
            ->add('count_transportation', 'integer')
            ->add('price_by_transportation', 'integer')
            ->add('departure_place', 'text')
            ->add('destination_place', 'text')
            ->add('save', 'submit', array(
                'label' => 'Сохранить'
                ));
    }

    public function getName()
    {
        return 'Act';
    }
}