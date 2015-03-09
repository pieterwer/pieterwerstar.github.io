<?php
namespace Event\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Adapter\AdapterInterface;

class LabelForm extends Form
{

    protected $dbAdapter;

    protected $action;
    
    protected $eventid;

    public function __construct(AdapterInterface $dbAdapter , $eventid  , $action = null, $name = null, $options = array())
    {
        $this->setDbAdapter($dbAdapter);
        $this->setAction($action);
        $this->setEventid($eventid);
        
        parent::__construct('label');
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setHydrator(new ClassMethods());

        
        $this->add(array(
            'name'    => 'label',
            'type'    => 'Zend\Form\Element\MultiCheckbox',
            'options' => array(
                'label'         => 'Label: ',
                'value_options' => $this->getOptionsForLabel($eventid)
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'class' => 'btn btn-primary',
            ),
        ));
        
    }
        /**
         * @return the $dbAdapter
         */

        function getDbAdapter()
        {
            return $this->dbAdapter;
        }
        
        /**
         * @param field_type $dbAdapter
         */

        function setDbAdapter($dbAdapter)
        {
            $this->dbAdapter = $dbAdapter;
        }
        /**
         * @return the $action
         */

        function getAction()
        {
            return $this->action;
        }
        
        /**
         * @param field_type $action
         */

        function setAction($action)
        {
            $this->action = $action;
        }
        
        /**
     * @return the $eventid
     */
    public function getEventid()
    {
        return $this->eventid;
    }

		/**
     * @param field_type $eventid
     */
    public function setEventid($eventid)
    {
        $this->eventid = $eventid;
    }

		public function getOptionsForLabel($eventid)
        {
            if($this->dbAdapter){
                $dbAdapter = $this->getDbAdapter();
                $sql       = 'SELECT * FROM label where id not in (select labelid from event_label_zuordnung where eventid = ?)';
                $statement = $dbAdapter->query($sql);
                $result    = $statement->execute(array($eventid));
            } else {
                return null;
            }
        
            $selectData = array();
        
            foreach ($result as $res) {
                $selectData[$res['id']] = $res['Labelname'];
            }
        
            return $selectData;
        }
    
}