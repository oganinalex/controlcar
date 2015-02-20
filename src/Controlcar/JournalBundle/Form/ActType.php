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
            ->add('cargo_type', 'text')
            ->add('transposition', 'entity', array(
                 'class' => 'ControlcarJournalBundle:Transposition',
                 'property' => 'name',
                 'expanded' => true,
                 'attr' => array(
                    //'class' => 'hide'
                    )
                 ))
            ->add('distance', 'integer', array(
                                         'data' => 0
                                         ))
            ->add('price_by_km', 'money', array(
                                          'currency' => 'UAH',
                                          'data' => 0
                                          ))
            ->add('count_transportation', 'integer', array(
                                                       'data' => 0
                                                       ))
            ->add('price_by_transportation', 'integer', array(
                                                        'data' => 0
                                                        ))
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