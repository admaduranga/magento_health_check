# Health Check For Magento

This is a standalone php application packaged as a phar file that can be installed in Magento applicatoin servers. When a  health check pulse (for example, called from the load balancer (ELB). This application will iterate through the enabled services (using a config.php) and check if all services are up and running 

## Getting Started

These instructions can be used to setup the health check application on the server


### Installing

- Download the build directory or below listed files and place it in appropriate project location
    - dms-health-check.phar
    - config.php
- Copy the `run.php` to a project root or sub directory that can be accessed by ELB
- Edit the `run.php` and chang
e the path to the `dms-health-check.phar`
```php
<?php
//** example run.php */
require "[DOC_ROOT]/health-check/dms-health-check.phar";
```
- Turn on the available services using `config.php`
```php
<?php
//Environment configurations
return [
    'project' => [
        'doc_root' => '/var/www/html/your_docroot',
        'local_config' => 'app/etc/local.xml',
        'main_config' => 'config_m1.php'
    ],
    'service' =>
        [
            'internal-mysql-database'   => ['status' => 1],
            'internal-redis-cache'      => ['status' => 1],
            'internal-redis-fpc'        => ['status' => 1],
            'internal-memcache-session' => ['status' => 1],
            'internal-nfs-media'        => ['status' => 1],
            'internal-nfs-var'          => ['status' => 1],
            'internal-solr-search'      => ['status' => 0],
        ]
];
```
- If you are using an Magento 1.x project please use 
```php 
'main_config' => 'config_m1.php'
```
- For Magento 2.x projects please use 
```php 
'main_config' => 'config_m2.php'
```

## Running the tests

Let the ELB call the run.php or using terminal
```text
> php run.php
```
If all services are good, the HTTP response will be 200 otherwise 500 with error messages.

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Version
Current version = **`0.0.3 beta`** 

## Authors

* **A. Dilhan Maduranga** - [Bit Bucket Project](https://bitbucket.org/dilhan_maduranga/)

## Improvements
- Magento 2.x version of this project is still under testing
- Revise each Service class to improve the availability criteria
 