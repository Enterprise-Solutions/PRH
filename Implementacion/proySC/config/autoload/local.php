<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
    'db' => array(
        'driver'   => 'Pdo_Pgsql',
        'dsn'      => 'pgsql:host=127.0.0.1;dbname=proysc',
        'username' => 'postgres',
        'password' => 'GuidoUCA2011',
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'postgres',
                    'password' => 'GuidoUCA2011',
                    'dbname'   => 'proysc',
                ),
            ),
        ),
    ),
);