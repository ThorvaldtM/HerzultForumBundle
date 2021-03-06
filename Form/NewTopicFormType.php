<?php

namespace Herzult\Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('subject');
        $builder->add('category');
        $builder->add('firstPost', $options['post_form'], array('data_class' => $options['post_class']));
    }

    public function getDefaultOptions()
    {
        return array(
            'post_class'    => '',
            'post_form'     => '',
            'data_class'    => '',
        );
    }

    public function getName()
    {
        return 'NewTopic';
    }
}
