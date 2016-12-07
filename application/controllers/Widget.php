<?php

/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');

class WidgetController extends Controller {

    public function getDBList() {
        $model = new Model();
        $dbList = $model->listDatabases();
        $aRetVal = array();

        foreach($dbList as $dbItem) {
            if (isset($dbItem['databases']) && is_a($dbItem['databases'], '\MongoDB\Model\BSONArray')) {
                foreach ($dbItem['databases'] as $db) {
                    $aRetVal[] = [
                        'name' => $db['name'],
                        'noOfCollecton' => iterator_count($model->listCollections($db['name'], array()))
                    ];
                }
            } else {
                $aRetVal = Helper::getLoginDatabase();
            }
        }
        return $aRetVal;
    }

    public function getCollectonList() {
        $chttp = new Chttp();
        $db = $chttp->getParam('db');
        if (!empty($db)) {
            $model = new Collection();
            $collections = $model->listCollections($db, array());
            $collectionList = array();
            foreach ($collections as $collection) {
                $collectionList[] = array('name' => $collection->getName(), 'count' => $model->totalRecord($db, $collection->getName()));
            }
            return $collectionList;
        } else {
            return FALSE;
        }
    }

    public function getLanguageList() {
        return Config::$language;
    }

}

?>
