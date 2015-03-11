<?php
namespace Veranstalter\Form;

use Zend\InputFilter\InputFilter;

class VeranstalterFilter extends InputFilter
{

    public function __construct()
    {
       
            $this->add(array(
                'name' => 'passwort',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Bitte geben Sie ihr Passwort ein.',
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => '8',
                            'max' => '16',
                            'messages' => array(
                                'stringLengthTooShort' => 'Bitte geben Sie ein Passwort mit mindestens 8 Zeichen ein!',
                                'stringLengthTooLong' => 'Bitte geben Sie ein Passwort mit höchstens 16 Zeichen ein!'
                            )
                        )
                    ),
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'passwort',
                            'messages' => array(
                                'notSame' => 'Die beiden Passwörter müssen Übereinstimmen!'
                            )
                        )
                    )
                )
            ));
        
        $this->add(array(
            'name' => 'passwort2',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihren Passwort nocheinmal.',
                        ),
                    ),
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => '8',
                        'max' => '16',
                        'messages' => array(
                            'stringLengthTooShort' => 'Bitte geben Sie ein Passwort mit mindestens 8 Zeichen ein!',
                            'stringLengthTooLong' => 'Bitte geben Sie ein Passwort mit höchstens 16 Zeichen ein!'
                        )
                    )
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'passwort',
                        'messages' => array(
                            'notSame' => 'Die beiden Passwörter müssen Übereinstimmen!'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'logindaten',
                        'field' => 'Email',
                        'messages' => array(
                            'recordFound' => 'Die Email-Adresse wird bereits verwendet.'
                        ),
                        'adapter' => \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter()
                    )
                )
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'email2',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihre Email-Adresse nochmal ein.',
                        ),
                    ),
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'email',
                        'messages' => array(
                            'notSame' => 'Die beiden Email-Adressen müssen Übereinstimmen!'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie keine Zahlen oder Sonderzeichen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(!preg_match('/^[a-zA-Z-_.]{0,50}$/', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihren Namen ein.',
                        ),
                    ),
                ),
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'iban',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie nur Buchstaben oder Zahlen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(!preg_match('/^[a-zA-Z-0-9_.]{0,50}$/', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihre IBAN ein.',
                        ),
                    ),
                ),
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'bic',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie nur Buchstaben oder Zahlen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(!preg_match('/^[a-zA-Z-0-9_.]{0,50}$/', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihre BIC ein.',
                        ),
                    ),
                ),
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'vorname',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie keine Zahlen oder Sonderzeichen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(!preg_match('/^[a-zA-Z-_.]{0,50}$/', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihren Vornamen ein.',
                        ),
                    ),
                ),
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'firmenname',
            'required' => false,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie keine Zahlen oder Sonderzeichen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(!preg_match('/^[a-zA-Z-_.]{0,50}$/', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                      
            )
        )
        );
        
        $this->add(array(
            'name' => 'strasse',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie keine Zahlen oder Sonderzeichen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(!preg_match('/^[a-z,A-Z,ß]{0,50}$/', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihre Strasse ein.',
                        ),
                    ),
                ),
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'hausnummer',
            'required' => true,
            'validators' => array(
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Bitte geben Sie keine Zahlen oder Sonderzeichen ein!'
                    ),
                    'callback' => function ($value)
                    {
                        if(preg_match('^(.+?)\s([0-9a-z]+(?:\s*-\s*[0-9a-z]+)?)$^', trim($value))){
                            return false;
                        }
                        return true;
                    }
                )),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihre Hausnummer ein.',
                        ),
                    ),
                ),
        
            )
        )
        );
        
        $this->add(array(
            'name' => 'postleitzahl',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Bitte geben Sie Ihre Postleitzahl ein.',
                        ),
                    ),
                ),
                array(
                    'name' => 'Zend\Validator\Db\RecordExists',
                    'options' => array(
                        'table' => 'zipcode',
                        'field' => 'zipcode',
                        'messages' => array(
                            'noRecordFound' => 'Bitte geben Sie eine korrekte Postleitzahl ein.',
                        ),
                        'adapter' => \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter()
                    )
                
                ),
                new \Zend\Validator\Callback(array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'Eine Postleitzahl besteht aus 5 Zahlen z.B. 94474'
                    ),
                    'callback' => function ($value)
                    {
                        if($value!= null && !ereg("^[0-9]{5,5}$", $value)){
                            return false;
                        }
                        return true;
                    }
                ))
            )
        )
        );
    }
}