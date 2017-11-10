<?php
//Environment configurations
return [
    'project' => [
        'doc_root' => '/var/www/html/docker/nsweb/m1141_ee',
        'local_config' => 'app/etc/local.xml',
        'framework' => 'magento_1'
    ],
    'service' => [
        'internal-mysql-database' => [
            'magento_1' => [
                'service_class' => "\\Classes\\Service\\MySql",
                'config_class' => "\\Classes\\Service\\MySql",
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
            'magento_2' => [
                'connection' => [
                    'service_class' => "Classes\\Helper\\Magento2Config",
                    'path' => 'db/connection/default',
                    'map' => [
                        'host' => 'host',
                        'dbname' => 'dbname',
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ]

        ],
        'internal-redis-cache' => [
            'magento_1' => [
                'service_class' => "\\Classes\\Service\\Redis",
                'connection' => [
                    'path' => 'global/cache/backend_options',
                    'map' => [
                        'server' => 'server',
                        'port' => 'port'
                    ]
                ]
            ]
        ],
        'internal-redis-fpc' => [
            'magento_1' => [
                'service_class' => "\\Classes\\Service\\Redis",
                'connection' => [
                    'path' => 'global/full_page_cache/backend_options',
                    'map' => [
                        'server' => 'server',
                        'port' => 'port'
                    ]
                ]
            ]
        ],
        'internal-memcache-session' => [
            'magento_1' => [
                'service_class' => "\\Classes\\Helper\\MagentoConfig",
                'connection' => [
                    'path' => 'global/session_save',
                ]
            ]
        ],
        'internal-nfs-media' => [
            'magento_1' => [
                'service_class' => "\\Classes\\Service\\DirCheck",
                'dir_path' => '/media',
            ]
        ],
        'internal-nfs-var' => [
            'magento_1' => [
                'service_class' => "\\Classes\\Service\\DirCheck",
                'dir_path' => '/var',
            ]
        ],
        'internal-solr-search' => [
            'magento_1' => [
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
            ]
        ],
    ]
];