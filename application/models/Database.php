<?php

/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');


class Database extends Model {

    public function createDB($name) {
        try {
            return $this->mongo->selectDatabase($name);
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function dropDatabase($db) {
        try {
            return $this->mongo->{$db}->drop();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function renameDatabase($oldDB, $newDB) {
        try {
            $response = $this->copyDatabase($oldDB, $newDB);
            if ($response['ok'] == 1) {
                try {
                    $response = $this->mongo->{$oldDB}->command(array('dropDatabase' => 1));
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return isset($response['errmsg']) ? $response['errmsg'] : 'Report Bug Erro Code :PMD-RD-32';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function repair($db) {
        return $this->mongo->{$db}->repair();
    }

/*
    public function execute($db, $code, array $args = array()) {
        try {
            $command = new \MongoDB\Driver\Command(['ping' => 1]);
            return $this->mongo->executeCommand($db, $code, $args);
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
*/
        public function isDbExist($db) {
        $databases = $this->listDatabases();

        $it = new \IteratorIterator($databases);
        $it->rewind(); // Very important
        $databases = $it->current();
        foreach ($databases['databases'] as $db) {
            $dbList[]=$db->name;
        }
        $seesion = Application::getInstance('Session');
        $tmpDbList = (!empty($seesion->databases) ? $seesion->databases : array());
        $list=array_merge($dbList, $tmpDbList);
        return (in_array($db, $list)?TRUE:FALSE);
    }

}
