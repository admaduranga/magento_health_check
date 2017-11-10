<?php
//Environment configurations
return [
    'project' => [
        //'doc_root' => '/var/www/html/docker/nsweb/m1141_ee',
        'doc_root' => '/var/www/html/camila/codepool',
        'local_config' => 'app/etc/local.xml',
        'main_config' => 'config_m1.php'
    ],
    'service' =>
        [
            'internal-mysql-database' =>
                [
                    'status' => 0
                ],
            'internal-redis-cache' =>
                [
                    'status' => 0
                ],
            'internal-redis-fpc' =>
                [
                    'status' => 0
                ],
            'internal-memcache-session' =>
                [
                    'status' => 1
                ],
            'internal-nfs-media' =>
                [
                    'status' => 0
                ],
            'internal-nfs-var' =>
                [
                    'status' => 0
                ],
            'internal-solr-search' =>
                [
                    'status' => 0
                ],
        ]
];