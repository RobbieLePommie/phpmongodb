<?php

/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');

?>
<div class="header">
    <h1 class="page-title">Output</h1>
</div>


<div class="well" >


    <p id="execute-response">
        <?php
        if (!empty($this->data['response'])) {
            echo "<pre>";
            print_r($this->data['response']);
            echo "</pre>";
        }
        ?>
    </p>
</div>