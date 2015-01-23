<?php

return array(
    'name' => 'Property name',
    'description' => 'Property description',
    'values' => 'Allowable values',
    'uploadPopupHelpTitle' => 'File specifications',
    'uploadPopupHelpContent' => '<ul>'
    . '<li>"id_sample" field is mandatory.</li>'
    . '<li>Column names must be in the first row of the file.</li>'
    . '<li>Only columns with the first line is <b> exactly </b> to a property name will be added to the sample properties.</li>'
    . '<li>
Columns whose first line is not exactly a property name will be added as notes associated with the sample.</li>'
    . '</ul>'
);


