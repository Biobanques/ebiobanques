<div class="help " >
    <div class=" help-title" >
        <?php echo "Groupe ICCC : $group" ?>
    </div>
    <br>
    <div class=" help-title" >
        <?php echo "Sous groupe ICCC : $sous_group" ?>
    </div>
</div>
<?php
$this->renderPartial("_details", array('dataProvider' => $dataProvider));


