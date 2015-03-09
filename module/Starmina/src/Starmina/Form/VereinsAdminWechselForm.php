<?php
namespace Starmina\Form;

use Zend\Form\Form;

class VereinsAdminWechselForm extends Form
{
	public function __construct($name = null)
	{
		
			
		parent::__construct('verein');
	
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		
			
		$this->add(array(
				'name' => 'Vereinsvertreter',
				'type' => 'Text',
				'options' => array(
						'label' => '',
				),
		));
			
		
			
		$this->add(array(
				'name' => 'Adminemail',
				'type' => 'Text',
				'options' => array(
						'label' => '',
				),
		));
		
		$this->add(array(
				'name' => 'wechsel',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Vereinsadministratorwechsel beantragen', 
						'id' => '', 
						'class' => 'button',
				),
		));
			
		
		
	}
	}
	?>