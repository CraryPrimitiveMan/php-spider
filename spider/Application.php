<?php
use RedBeanPHP\R;

class Application
{
    public $config = null;

    public function __construct($config)
    {
        $this->config = $config;
        R::setup('mysql:host=localhost;dbname=spider', 'root', 'jun');
    }

    public function run()
    {
        $config = $this->config;
        if (!empty($config[1]) && !empty($config['spider'] && !empty($config['spider'][$config[1]]))) {
            $spiderConfig = $config['spider'][$config[1]];
            extract($spiderConfig);
            $spider = new $className($startUrl, $depth);
            $spider->crawlUrl();
        } else {
            throw new Exception('Config error');
        }
    }
}
