<?php
//Environment configurations
return [
    'project' => [
        'doc_root' => '/var/www/html/docker/nsweb/m1141_ee',
        'local_config' => 'app/etc/local.xml',
        'main_config' => 'config_m1.php'
    ],
    'service' =>
        [
            'internal-mysql-database' =>
                [
                    'active' => 1
                ],
            'internal-redis-cache' =>
                [
                    'active' => 0
                ],
            'internal-redis-fpc' =>
                [
                    'active' => 0
                ],
            'internal-memcache-session' =>
                [
                    'active' => 0
                ],
            'internal-nfs-media' =>
                [
                    'active' => 1
                ],
            'internal-nfs-var' =>
                [
                    'active' => 1
                ],
            'internal-solr-search' =>
                [
                    'active' => 1
                ],
        ]
];