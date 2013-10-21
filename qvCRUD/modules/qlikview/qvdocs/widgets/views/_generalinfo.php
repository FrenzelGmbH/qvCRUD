<?php

use yii\helpers\Html;

?>

<div class="widget">
    <?php 
      foreach($infoText as $key=>$value){
        foreach($value["PrjQlikViewProject"][0]["GLOBAL"] as $key => $svalue){
          foreach ($svalue as $key => $ssvalue) {
            echo strtoupper($key) . ' : '.$ssvalue.'<br>';
           } 
        }
      }
    ?>
</div>