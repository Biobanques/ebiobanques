<?php

/**
 * Auther aoyagikouhei
 *
 * 2011/08/01 ver 1.2
 * Add fsync, safe, timeout options
 *
 * 2011/07/09 ver 1.1
 * Add capped collection : Thank you joblo
 *
 * 2011/06/23 ver 1.0
 * First release
 *
 * Install
 * Extract the release file under protected/extensions
 *
 * In config/main.php:
  'log'=>array(
  'class'=>'CLogRouter',
  'routes'=>array(
  array(
  'class'=>'ext.EMongoDbLogRoute',
  'levels'=>'trace, info, error, warning',
  'categories' => 'system.*',
  ),
  ),
  ),
 *
 * Options
 * connectionString        : host:port                      : defalut localhost:27017
 * dbName                  : database name                  : default test
 * collectionName          : collaction name                : default yiilog
 * message                 : message column name            : default message
 * level                   : level column name              : default level
 * category                : category column name           : default category
 * timestamp               : timestamp column name          : default timestamp
 * timestampType           : float or date                  : default float
 * collectionSize          : capped collection size         : default 10000
 * collectionMax           : capped collection max          : default 100
 * installCappedCollection : capped collection install flag : default false
 * fsync                   : fsync flag                     : defalut false
 * safe                    : safe flag                      : defalut false
 * timeout                 : timeout miliseconds            : defalut null i.e. MongoCursor::$timeout
 *
 * Example
  'log'=>array(
  'class'=>'CLogRouter',
  'routes'=>array(
  array(
  'class'=>'ext.EMongoDbLogRoute',
  'levels'=>'trace, info, error, warning',
  'categories' => 'system.*',
  'connectionString' => 'localhost:27017',
  'dbName' => 'test',
  'collectionName' => 'yiilog',
  'message' => 'message',
  'level' => 'level',
  'category' => 'category',
  'timestamp' => 'timestamp',
  'timestampType' => 'float',
  ,'collectionSize' => 10000
  ,'collectionMax' => 100
  ,'installCappedCollection' => true
  ),
  ),
  ),
 *
 * Capped colection
 * 1. set installCappedCollection true in main.php.
 * 2. run application and loged
 * 3. remove installCappedCollection in main.php.
 */
class EMongoDbLogRoute extends CLogRoute
{
    /**
     * @var string Mongo Db host + port
     */
    public $connectionString = "localhost:27017";
    /**
     * @var string Mongo Db Name
     */
    public $dbName = "test";
    /**
     * @var string Collection name
     */
    public $collectionName = "yiilog";
    /**
     * @var string message column name
     */
    public $message = "message";
    /**
     * @var string level column name
     */
    public $level = "level";
    /**
     * @var string category column name
     */
    public $category = "category";
    /**
     * @var string timestamp column name
     */
    public $timestamp = "timestamp";
    /**
     * @var string timestamp type name float or date
     */
    public $timestampType = "float";
    /**
     * @var integer capped collection size
     */
    public $collectionSize = 10000;
    /**
     * @var integer capped collection max
     */
    public $collectionMax = 100;
    /**
     * @var boolean capped collection install flag
     */
    public $installCappedCollection = false;
    /**
     * @var boolean forces the update to be synced to disk before returning success.
     */
    public $fsync = false;
    /**
     * @var boolean the program will wait for the database response.
     */
    public $safe = false;
    /**
     * @var boolean if "safe" is set, this sets how long (in milliseconds) for the client to wait for a database response.
     */
    public $timeout = null;
    /**
     * @var Mongo mongo Db collection
     */
    private $collection;
    /**
     * @var array insert options
     */
    private $options;

    /**
     * Initializes the route.
     * This method is invoked after the route is created by the route manager.
     */
    public function init() {
        parent::init();
        $connection = new Mongo($this->connectionString);
        $dbName = $this->dbName;
        $collectionName = $this->collectionName;
        if ($this->installCappedCollection) {
            $this->collection = $connection->$dbName->createCollection(
                    $collectionName, true, $this->collectionSize, $this->collectionMax
            );
        } else {
            $this->collection = $connection->$dbName->$collectionName;
        }
        $this->options = array(
            'fsync' => $this->fsync
            , 'safe' => $this->safe
        );
        if (!is_null($this->timeout)) {
            $this->options['timeout'] = $this->timeout;
        }
    }

    /**
     * Saves log messages into mongodb.
     * @param array list of log messages
     */
    protected function processLogs($logs) {
        foreach ($logs as $log) {
            $this->collection->insert(array(
                $this->message => $log[0]
                , $this->level => $log[1]
                , $this->category => $log[2]
                , $this->timestamp =>
                'date' === $this->timestampType ? new MongoDate(round($log[3])) : $log[3]
                    ), $this->options);
        }
    }

}