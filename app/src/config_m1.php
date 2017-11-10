<?php
//Environment configurations
return [
    'project' => [
        'config_reader' => "\\Classes\\ConfigReaders\\Magento"
    ],
    'service' => [
        'internal-mysql-database' => [
            'service_class' => "\\Classes\\Service\\MySql",
            'connection' => [
                'path' => 'global/resources/default_setup/connection',
                'map' => [
                    'host' => 'host',
                    'dbname' => 'dbname',
                    'username' => 'username',
                    'password' => 'password',
                ]
            ]
        ],
        'internal-redis-cache' => [
            'service_class' => "\\Classes\\Service\\Redis",
            'connection' => [
                'path' => 'global/cache/backend_options',
                'map' => [
                    'server' => 'server',
                    'port' => 'port'
                ]
            ]
        ],
        'internal-redis-fpc' => [
            'service_class' => "\\Classes\\Service\\Redis",
            'connection' => [
                'path' => 'global/full_page_cache/backend_options',
                'map' => [
                    'server' => 'server',
                    'port' => 'port'
                ]
            ]
        ],
        'internal-memcache-session' => [
            'service_class' => "\\Classes\\Service\\Memcache",
            'connection' => [
                'path' => 'global',
                'map' => [
                    'session_save' => 'session_save',
                    'session_save_path' => 'session_save_path'
                ]
            ]
        ],
        'internal-nfs-media' => [
            'service_class' => "\\Classes\\Service\\DirCheck",
            'dir_path' => '/media'
        ],
        'internal-nfs-var' => [
            'service_class' => "\\Classes\\Service\\DirCheck",
            'dir_path' => '/var'
        ],
        'internal-solr-search' => [
            'service_class' => "\\Classes\\Service\\Solr",
            'connection' => [
                'path' => 'global/resources/default_setup/connection',
                'map' => [
                    'host' => 'host',
                    'dbname' => 'dbname',
                    'username' => 'username',
                    'password' => 'password',
                ]
            ],
            'params' => [
                'solr_host' => 'catalog/solr_search/solr_server_hostname',
                'solr_port' => 'catalog/solr_search/solr_server_port'
            ]
        ],
    ]
];