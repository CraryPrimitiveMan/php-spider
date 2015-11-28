<?php
namespace spider\site;

use Requests;
use phpQuery;
use Exception;

abstract class BaseSite implements SiteInterface
{
    const MAX_RETRY_COUNT = 10;
    /**
     * @var string the current url
     */
    protected $currentUrl = '';

    /**
     * @var string the depth for current url
     */
    protected $currentDepth = 0;

    /**
     * @var string the max depth
     */
    protected $maxDepth = 1;

    /**
     * @var array the waiting urls
     */
    protected $wait = [];

    /**
     * @var array the used urls that haven not get related url
     */
    protected $cache = [];

    /**
     * @var integer the retry count
     */
    protected $retryCount = 0;

    public function __construct($startUrl, $depth)
    {
        $this->currentUrl = $startUrl;
        $this->maxDepth = $depth;
    }

    public function setCurrentUrl($url)
    {
        $this->currentUrl = $url['url'];
        $this->currentDepth = $url['depth'];

        if ($this->currentDepth < $this->maxDepth) {
            $this->addFollowing($this->currentUrl);
            $this->addFollowers($this->currentUrl);
        }
    }

    public function crawlUrl()
    {
        return $this->getDocumentFromUrl($this->currentUrl);
    }

    public function getDocumentFromUrl($url)
    {
        try {
            $html = Requests::get($url);
        } catch (Exception $e) {
            if ($this->retryCount < static::MAX_RETRY_COUNT) {
                echo 'Retry:', ++$this->retryCount, PHP_EOL;
                echo 'Url:', $url, PHP_EOL;
                return $this->getDocumentFromUrl($url);
            }
            echo 'Requests Exception:', $url, PHP_EOL;
            return false;
        }

        $this->retryCount = 0;
        return phpQuery::newDocument($html->body);
    }
}
