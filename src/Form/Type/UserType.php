<?php

namespace WebLinks\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Form builder for users
 *
 * @author Steven DUMONT <windir10 at gmail.com>
 */
class UserType extends AbstractType {
	
	/**
	 * Form builder function
	 * 
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type'            => PasswordType::class,
                 'invalid_message' => 'The password fields must match.',
                 'options'         => array('required' => true),
                 'first_options'   => array('label' => 'Password'),
                 'second_options'  => array('label' => 'Repeat password'),
             ))
            ->add('role', ChoiceType::class, array(
                'choices' => array('Admin' => 'ROLE_ADMIN', 'User' => 'ROLE_USER')
            ));
    }
	
	/**
	 * Return form's name type
	 * 
	 * @return string Form's name type
	 */
	public function getName() {
		return 'user';
	}
}
