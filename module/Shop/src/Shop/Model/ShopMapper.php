<?php
namespace Shop\Model;

use Zend\Db\Adapter\Adapter;
use Shop\Model\ShopEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class ShopMapper
{
    protected $tableName = 'shop';
    protected $dbAdapter;
    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $select = $this->sql->select();
        //$select->order(array('completed ASC', 'created ASC'));

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $entityPrototype = new ShopEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    
    public function saveShop(ShopEntity $shop)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($shop);
    
        if ($shop->getId()) {
            // update action
            $action = $this->sql->update();
            $action->set($data);
            $action->where(array('id' => $shop->getId()));
        } else {
            // insert action
            $action = $this->sql->insert();
            unset($data['id']);
            $action->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if (!$shop->getId()) {
            $shop->setId($result->getGeneratedValue());
        }
        return $result;
    
    }
    
    public function Ergebnisev($evid, $sort = null)
    {
        $select = $this->sql->select();
        // Grš§er gleich wurde noch nicht umgesetzt!!!
        if($sort == 1)
        {
            $select->where->between('Alter', 0, 4);
        }
        if($sort == 2)
        {
            $select->where->between('Alter', 0, 5);
        }
        if($sort == 3)
        {
            $select->where->between('Alter', 0, 6);
        }
        if($sort == 4)
        {
            $select->where->between('Alter', 0, 9);
        }
        if($sort == 5)
        {
            $select->where->between('Alter', 0, 11);
        }
        if($sort == 6)
        {
            $select->where->between('Alter', 0, 13);
        }
        if($sort == 7)
        {
            $select->where->between('Alter', 0, 18);
        }
        if($sort == 8)
        {
            $select->where->between('Alter', 18, 29);
        }
        if($sort == 9)
        {
            $select->where->between('Alter', 30, 34);
        }
        if($sort == 10)
        {
            $select->where->between('Alter', 35, 39);
        }
        if($sort == 11)
        {
            $select->where->between('Alter', 40, 44);
        }
        if($sort == 12)
        {
            $select->where->between('Alter', 45, 49);
        }
        if($sort == 13)
        {
            $select->where->between('Alter', 50, 54);
        }
        if($sort == 14)
        {
            $select->where->between('Alter', 55, 59);
        }
        if($sort == 15)
        {
            $select->where->between('Alter', 60, 64);
        }
        if($sort == 16)
        {
            $select->where->between('Alter', 65, 69);
        }
        if($sort == 17)
        {
            $select->where->between('Alter', 70, 74);
        }
        if($sort == 18)
        {
            $select->where->between('Alter', 75, 79);
        }
        if($sort == 19)
        {
            $select->where->between('Alter', 80, 200);
        }
        $select->where(array('eventid' => $evid));
        $select->order(array('zeit ASC'));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
//         print_r($results);
    
        $entityPrototype = new ErgebnisEntity();
        $hydrator = new ClassMethods();
        $resultset = new HydratingResultSet($hydrator, $entityPrototype);
        $resultset->initialize($results);
        return $resultset;
    }
    
    public function getShop($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id ));
    
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if (!$result) {
            return null;
        }
    
        $hydrator = new ClassMethods();
        $shop = new ShopEntity();
        $hydrator->hydrate($result, $shop);
    
//         print_r($shop);
        return $shop;
    }
    
    public function getLink($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`shop` b WHERE a.id = b.artikelbildid AND b.artikelbildid = ?', array($bid));
        $test = $action->toArray();

        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../pictures/default_pic.jpg";
            return $link;
        } 
        else 
        {
            $name = $test[0]['Link'];
            $link = "../img/";
            $link .= $name;
            return $link;
        }       

    }
    
    public function getLinkV($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`shop` b WHERE a.id = b.artikelbildid AND b.artikelbildid = ?', array($bid));
        $test = $action->toArray();
    
        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../../pictures/default_pic.jpg";
            return $link;
        }
        else
        {
            $name = $test[0]['Link'];
            $link = "../../img/";
            $link .= $name;
            return $link;
        }
    
    }
    
    public function getLink3($bid)
    {
        $action = $this->dbAdapter->query('SELECT `Link` FROM `bild` a,`shop` b WHERE a.id = b.artikelbildid AND b.artikelbildid = ?', array($bid));
        $test = $action->toArray();
    
        //†berprŸfen ob es noch kein Bild gibt
        if(empty($test))
        {
            $link = "../../../pictures/default_pic.jpg";
            return $link;
        }
        else
        {
            $name = $test[0]['Link'];
            $link = "../../../img/";
            $link .= $name;
            return $link;
        }
    
    }
    
    public function artikelbild($id, $bildid)
    {
        $action = $this->dbAdapter->query('UPDATE `shop` SET `Artikelbildid` = ? WHERE `shop`.`id` = ?', array($bildid, $id));
    }
    
    public function saveWarenkorb($veranstalter, $artikel, $menge)
    {
        echo "Anzahl";
        echo $menge;
        $action = $this->dbAdapter->query('INSERT INTO `bestellung`(`Artikelid`, `Status`, `Datum`, `Veranstalterid`, `Menge`) VALUES (?,0,NOW(),?,?)', array($artikel, $veranstalter, $menge));
    }
    
    public function deleteShop($id)
    {
        $delete = $this->sql->delete();
        $delete->where(array('id' => $id));
    
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        return $statement->execute();
    }
    
    public function deleteShopBestellung($shop)
    {
        $action = $this->dbAdapter->query('DELETE FROM `bestellung` WHERE `Artikelid`=?', array($shop->getId()));
    }
    public function deleteShopBild($shop)
    {
        $action2 = $this->dbAdapter->query('DELETE FROM `bild` WHERE `id`=?', array($shop->getArtikelbildid()));
    }
    
}