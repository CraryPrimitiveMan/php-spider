<?php
namespace spider\site;

interface SiteInterface
{
    public function setCurrentUrl($url);

    public function nextUrl();

    public function crawlUrl();
}
