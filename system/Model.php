<?php
/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');


class Model {

    protected $mongo;

    public function __construct() {

        $session = Application::getInstance('Session');
        $mongo = PHPMongoDB::getInstance($session->server, $session->options);
        $exception = $mongo->getExceptionMessage();
        if ($exception) {
            exit($exception);
        }
        $this->mongo = $mongo->getConnection();
    }

    public function listDatabases() {
        try {
            return $this->mongo->admin->command(array("listDatabases" => 1));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getMongoInfo() {
        try {
            $cursor = $this->mongo->admin->command(array('buildinfo' => true));
            $retval = 'false';
            if ($cursor) {
                foreach ($cursor as $document) {
                    $retval = $document;
                }
            }
            return $retval;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function renameCollection($oldCollecton, $newCollection, $dbFrom, $dbTo = false) {
        if (!$dbTo) {
            $dbTo = $dbFrom;
        }

        try {
            $command = array("renameCollection" => "$dbFrom.$newCollection", "to" => "$dbTo.$oldCollecton");
            return $this->mongo->admin->command($command);
        } catch (MongoConnectionException $e) {
            exit($e);
        }
    }

    public function copyDatabase($fromdb, $todb, $fromhost = 'localhost') {
        try {
            $response = $this->mongo->admin->command(array('copydb' => 1, 'fromhost' => $fromhost, 'fromdb' => $fromdb, 'todb' => $todb));
            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function __call($name, $arguments) {
        try {
            return $this->mongo->{$arguments[0]}->$name($arguments[1]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

//
//    public function getCollectionNames($db,$includeSystemCollections = false ) {
//        return $this->mongo->{$db}->getCollectionNames($includeSystemCollections);
//    }


    public function find($db, $collection, $query = array(), $fields = array(), $limit = false, $skip = false, $format = 'array', $orderBy = array('_id' => 1)) {
        $aOptions = [];
        if ($skip !== false) {
            $aOptions['skip'] = $skip;
        }
        if ($limit !== false) {
            $aOptions['limit'] = $limit;
        }
        if ($orderBy !== false) {
            $aOptions['sort'] = $orderBy;
        }


        try {
            $retval = $this->mongo->{$db}->{$collection}->find($query, $aOptions);
//            if ($format == 'array') {
//                $retval = $retval->toArray();
//            }
/*
            if ($format == 'json') {
                $aRetVal = array();

                $code = "return db.getCollection('" . $collection . "').find(" . $query . ").limit(" . $limit . ").skip(" . $skip . ").sort(" . json_encode($ordeBy) . ").toArray();";
                $response = $this->mongo->{$db}->execute($code);
                if ($response['ok'] == 1) {
                    return $response['retval'];
                }
            } else {
                $retval = $cursor;
            }
            return false;
*/
        } catch (Exception $e) {
            exit($e->getMessage());
        }
        return $retval;
    }

    public function insert($db, $collection, $a, $format = 'array', $options = array()) {
        try {
            if ($format == 'json') {
                $a = @json_decode($a);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return false;
                }
            }
            return $this->mongo->{$db}->{$collection}->insertOne($a);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    public function serverStatus() {
        try {
            $response = $this->mongo->admin->command(array('serverStatus' => 1));
            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateTemporaryDb($db, $oldDb) {
        $seesion = Application::getInstance('Session');
        $databases = (!empty($seesion->databases) ? $seesion->databases : array());
        if (!empty($databases)) {
            if (($key = array_search($oldDb, $databases)) !== false) {
                unset($databases[$key]);
            }
            array_push($databases, $db);
            $seesion->databases = array_unique($databases);
            return $seesion->databases;
        }
        return FALSE;
    }

    public function saveTemporaryDb($db) {
        $seesion = Application::getInstance('Session');
        $databases = (!empty($seesion->databases) ? $seesion->databases : array());
        array_push($databases, $db);
        $seesion->databases = array_unique($databases);
        return $seesion->databases;
    }

    public function deleteTemporaryDb($db) {
        $seesion = Application::getInstance('Session');
        $databases = (!empty($seesion->databases) ? $seesion->databases : array());
        if (!empty($databases)) {
            if (($key = array_search($db, $databases)) !== false) {
                unset($databases[$key]);
            }
            $seesion->databases = array_unique($databases);
            return $seesion->databases;
        }
        return FALSE;
    }

}

?>
