<?php
return [
    'spider' => [
        'github' => [
            'className' => 'spider\site\GitHub',
            'startUrl' => 'https://github.com/agentzh',
            'depth' => 1
        ],
        'zhihu' => 'spider\site\Zhihu',
        'douban' => 'spider\site\Douban',
        'weibo' => 'spider\site\Weibo',
        'qqzone' => 'spider\site\QQ',
    ]
];
