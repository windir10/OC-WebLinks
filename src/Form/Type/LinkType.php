<?php

namespace WebLinks\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Form builder for links
 *
 * @author Steven DUMONT <windir10 at gmail.com>
 */
class LinkType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('title', TextType::class);
		$builder->add('url', TextType::class);
	}
	
	/**
	 * Return form's name type
	 * 
	 * @return string Form's name type
	 */
	public function getName() {
		return 'link';
	}
}
