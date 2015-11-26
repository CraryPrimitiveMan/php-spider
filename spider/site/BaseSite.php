<?php
namespace spider/site;

abstract class BaseSite implements SiteInterface
{
    /**
     * @var string the current url
     */
    protected $currentUrl = '';

    /**
     * @var array the waiting urls
     */
    protected $wait = [];

    /**
     * @var array the used urls that haven not get related url
     */
    protected $cache = [];

    public function setStartUrl($url)
    {
        $this->currentUrl = $url;
        return;
    }
}
