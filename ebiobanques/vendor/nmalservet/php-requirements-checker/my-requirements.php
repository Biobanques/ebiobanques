<?php

/**
 * my-requirements.php needs to store all the requirements for your application.
 * The expected syntax is the following
 *   ["TYPE","LIBRARY_NAME", "EXPECTED_VERSION","COMPATIBILITY_MODE", "ERROR_CRITICALITY"],
 *  example : 
 *   ["PHP_LIBRARY","pdo_mysql", "5.4.0","asc", "war"],
 * 
 * TYPE : defined values : PHP_LIBRARY, EXTERNAL_LIBRARY
 * 
 * LIBRARY_NAME : name of the library. If its a PHP LIbrary the common name.
 * If it's an external library, give the expected path
 * CUSTOM CONSTANT : PHP_VERSION as library name to check teh PHP version
 * 
 * COMPATIBILITY_MODE : defined values : asc, desc, strict
 * asc= ascendant compatibility allowed, desc= descendant compatibility allowed ( normal mode example: version 5.3 expected, if 5.4 installed : result ok), strict = strict compatibility equivalence
 * Most of the libraries are descendant compatibles
 * 
 * ERROR_CRITICALITY : defined values : notice,warn, error
 * notice = if the requirements is missing, print a blue line
 * warn = if the requirement is missing, print an orange line
 * error = if teh requirement is missing, print a red line
    
 * @author nicolas malservet
 */
$libraries_required=[
    ["PHP_LIBRARY","PHP_VERSION", "5.4.0","desc", "error"],
    ["PHP_LIBRARY","pdo_mysql", "1.0.2","desc", "error"],
    ["PHP_LIBRARY","mongo", "1.6.14","desc", "error"],
    ["PHP_LIBRARY","pgsql", "1.6.14","desc", "warn"],
    ["PHP_LIBRARY","gd", "1.6.14","desc", "warn"],
    
    
];

/**
 * Write here the expected folders required
 *   The expected syntax is the following
 *   ["FOLDER_NAME","ACCESS","ERROR_CRITICALITY"],
 * example
 *  ["test/","R","WARN"],
 * FOLDER_NAME : the path of the folder required
 * 
 * ACCESS : the acces rights for the given folder to the current user
 * Defined values : R, W, X
 * R= read, W= write, X = executable
 * 
 *  ERROR_CRITICALITY : defined values : notice,warn, error
 * notice = if the requirements is missing, print a blue line
 * warn = if the requirement is missing, print an orange line
 * error = if teh requirement is missing, print a red line
 */
$folders_required=[
    ["test","r", "warn"],
    ["runtime","w", "warn"],
    ["../php-requirements-checker","w", "warn"],
    ["webapp","w", "warn"],
];

        /**
 * Write here the expected files required
 *   The expected syntax is the following
 *   ["FILE_NAME","ACCESS","ERROR_CRITICALITY"],
 * example
 *  ["config.php","R","WARN"],
 * FOLDER_NAME : the path of the folder required
 * 
 * ACCESS : the acces rights for the given folder to the current user
 * Defined values : R, W, X
 * R= read, W= write, X = executable
 * 
 *  ERROR_CRITICALITY : defined values : notice,warn, error
 * notice = if the requirements is missing, print a blue line
 * warn = if the requirement is missing, print an orange line
 * error = if teh requirement is missing, print a red line
 */
$files_required=[
    ["config.php","R", "error"],
    ["README.md","R", "notice"],
];
?>


