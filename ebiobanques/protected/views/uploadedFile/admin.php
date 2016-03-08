<?php

$this->renderPartial("_form", array(
    'model' => $model,
    'dataProviderProperties' => $dataProviderProperties,
    'fileId' => $fileId,
    'add' => $add
));

