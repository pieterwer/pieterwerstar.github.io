<?php

namespace SanAuth\Model;

use Zend\Form\Annotation;

/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("User")
 */
class User
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Email: "})
     * @Annotation\Attributes({"style":"display: block"})
     */
    public $username;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Passwort:"})
     * @Annotation\Attributes({"style":"display: block"})
     */
    public $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Eingeloggt bleiben? "})
     */
    public $rememberme;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Login"}),
     * @Annotation\Attributes({"class":"button"})
     */
    public $submit;
}
