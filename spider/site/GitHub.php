<?php
namespace spider\site;

use RedBeanPHP\R;

class GitHub extends BaseSite
{
    public $baseUrl = 'https://github.com';
    public $pageSize = 51;

    public function nextUrl()
    {
        if (empty($this->wait) && !empty($this->cache)) {
            $urlObj = $this->cache[0];
            $url = $urlObj['url'] . '?page=' . $urlObj['size'];
            if ($doc = $this->getDocumentFromUrl($url)) {
                if ($urlObj['size'] == 1) {
                    array_shift($this->cache);
                } else {
                    $this->cache[0]['size']--;
                }

                $users = $doc['.follow-list-name a'];
                foreach ($users as $user) {
                    array_push($this->wait, ['url' => $this->baseUrl . pq($user)->attr('href'), 'depth' => $urlObj['depth']]);
                }
            }
        }

        if (!empty($this->wait)) {
            return array_shift($this->wait);
        }

        echo '完成爬取数据的任务', PHP_EOL;
        return false;
    }

    public function crawlUrl()
    {
        $currentUrl = ['url' => $this->currentUrl, 'depth' => $this->currentDepth];
        do {
            $this->setCurrentUrl($currentUrl);
            if (!($doc = parent::crawlUrl())) {
                continue;
            }
            $username = $doc['.vcard-username']->text();
            $user = R::findOne('github', ' username = ? ', [$username]);
            //$user = R::find('github', " username=$username ");
            if (empty($user)) {
                $user = R::dispense('github');
                $now = time();
                $user->avatar = $doc['.vcard-avatar .avatar']->attr('src');
                $user->fullname = $doc['.vcard-fullname']->text();
                $user->username = $username;
                $user->email = $doc['.email']->text();
                $user->worksFor = $doc['.vcard-detail[itemprop=worksFor]']->text();
                $user->homeLocation = $doc['.vcard-detail[itemprop=homeLocation]']->text();
                $user->blogUrl = $doc['.vcard-detail[itemprop=url]']->text();
                $user->joinDate = $doc['.join-date']->attr('datetime');
                $user->url = $this->currentUrl;
                $user->createdAt = $now;
                $user->updatedAt = $now;
                if (R::store($user)) {
                    echo '存储用户', $username, '成功', PHP_EOL;
                } else {
                    echo '存储用户', $username, '失败', PHP_EOL;
                }
            } else {
                echo '用户', $username, '已经被存储过了', PHP_EOL;
            }
        } while ($currentUrl = $this->nextUrl());
    }

    public function addFollowing($url)
    {
        $this->addUsers($url . '/following');
    }

    public function addFollowers($url)
    {
        $this->addUsers($url . '/followers');
    }

    public function addUsers($url)
    {
        if ($users = $this->getDocumentFromUrl($url)) {
            $count = (int) str_replace(',', '', $users['.counter']->text());
            $page = ceil($count / $this->pageSize);
            array_push($this->cache, ['url' => $url, 'depth' => $this->currentDepth + 1, 'size' => $page]);
        }
    }
}
