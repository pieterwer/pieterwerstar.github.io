<?php
namespace Search\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class SearchForm extends Form
{
    protected $dbAdapter;
    protected $action;
    
    public function __construct(AdapterInterface $dbAdapter = null, $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        
        parent::__construct('search');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setInputFilter(new SearchFilter());
//         $this->setHydrator(new ClassMethods());
        
        $this->add(array(
            'name'    => 'sportarten',
            'type'    => 'Zend\Form\Element\Radio',
            'options' => array(
                'label'         => 'Sportarten: ',
                'value_options' => $this->getOptionsForSportart(),
                'empty_option'  => '--- please choose ---'
            )
        ));
        
        $this->add(array(
            'name'    => 'kategorien',
            'type'    => 'Zend\Form\Element\MultiCheckbox',
            'required' => false,
            'options' => array(
                'label'         => 'Kategorien: ',
                'value_options' => $this->getOptionsForKategorien()
            )
        ));
        
        $this->add(array(
            'name'    => 'name',
            'type' => 'text',
            'options' => array(
                'label' => 'Suche:'
            ),
            'attributes' => array(
                'id' => 'name',
                'min' => 0,
                'maxlength' => 50,
            )
        ));
        
        $this->add(array(
            'name' => 'postleitzahl',
            'type' => 'number',
            'options' => array(
                'label' => 'PLZ: ',
            ),
            'attributes' => array(
                'id' => 'postleitzahl',
                'min' => 10000,
                'max' => 99999,
            )
        ));
        
        $this->add(array(
            'name' => 'umkreis',
            'type' => 'number',
            'options' => array(
                'label' => 'Umkreis: ',
            ),
            'attributes' => array(
                'id' => 'umkreis',
                'min' => 0,
                'max' => 200,
                'step' => 10,
            )
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'button',
            ),
        ));
    }
    
    public function getOptionsForKategorien()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM eventkategorie';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
    
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['Eventart'];
        }
    
        return $selectData;
    }
    
    public function getOptionsForSportart()
    {
        if($this->dbAdapter){
            $dbAdapter = $this->getDbAdapter();
            $sql       = 'SELECT * FROM sportart';
            $statement = $dbAdapter->query($sql);
            $result    = $statement->execute();
        } else {
            return null;
        }
    
        $selectData = array();
        $selectData[0] = 'Alle';
        foreach ($result as $res) {
            $selectData[$res['id']] = $res['Bezeichnung'];
        }
    
        return $selectData;
    }
    
    /**
     * @return the $dbAdapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
    
    /**
     * @param field_type $dbAdapter
     */
    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    /**
     * @return the $action
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @param field_type $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    
}