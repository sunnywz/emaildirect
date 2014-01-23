<?php

class EmailDirect
{
    const URL = 'https://rest.emaildirect.com/v1';
    
    public static $headers = array(
        'User-Agent' => 'emaildirect-rest-v1',
        'Content-Type' => 'application/json; charset=utf-8',
    );
    
    /**
     * @var string 
     */
    protected $_apiKey;
    
    /**
     * @var EmailDirect_Adapter_Curl 
     */
    protected $_adapter;
    
    private $_mapResources = array();
    
    public function __construct($apiKey)
    {
        $this->_apiKey = $apiKey;
    }

    public function __call($method, $args)
    {
        $class = 'EmailDirect_' . ucfirst($method);
        if (!isset($this->_mapResources[$class])) {
            $this->_mapResources[$class] = new $class($this->getAdapter());
        }
        if (isset($args[0])) {
            $this->setId($args[0]);
        }
        return $this->_mapResources[$class];
    }
    
    /**
     * @return EmailDirect_Adapter_Curl
     */
    public function getAdapter()
    {
        if ($this->_adapter === null) {
            $this->_adapter = new EmailDirect_Adapter_Curl(
                static::URL, 
                array_merge(static::$headers, array('ApiKey' => $this->_apiKey))
            );
        }
        return $this->_adapter;
    }
    
}