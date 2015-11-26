<?php
namespace spider;

interface SiteInterface
{
    public function setStartUrl($url);

    public function nextUrl($url);

    public function crawlUrl();
}
