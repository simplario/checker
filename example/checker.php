<?php

return [
    'tasks' => [
        // OK
        ['checker'  => 'filesystem', 'path' => 'README.md', 'exists' => true, 'writable' => true,
         'readable' => true, 'chmod' => '0764',],
        // Errors
        ['checker' => 'filesystem', 'path' => 'README.md', 'exists' => false],
        ['checker' => 'filesystem', 'path' => 'README.md', 'writable' => false],
        ['checker' => 'filesystem', 'path' => 'README.md', 'readable' => false],
        ['checker' => 'filesystem', 'path' => 'README.md', 'chmod' => '0755'],
        ['checker' => 'filesystem', 'path' => 'README.md-NONE', 'exists' => true],

        // OK
        ['checker' => 'service', 'name' => 'htop', 'exists' => true, 'version' => '2.0.1', 'which' => '/usr/bin/htop'],
        ['checker' => 'service', 'name' => 'php', 'exists' => true, 'version' => '7.0.8', 'which' => '/usr/bin/php'],
        ['checker' => 'service', 'name' => 'rrrrrrrrrr', 'exists' => false],
        // Errors
        ['checker' => 'service', 'name' => 'htop', 'exists' => false],
        ['checker' => 'service', 'name' => 'htop', 'version' => '9.9.9'],
        ['checker' => 'service', 'name' => 'htop', 'which' => '/usr/bin/-UNDEFINED-'],

        // Ok
        ['checker' => 'gateway', 'url' => 'http://google.com/', 'exists' => true],
        ['checker' => 'gateway', 'url' => 'http://undefined-undefined-undefined.com/', 'exists' => false],
        // Errors
        ['checker' => 'gateway', 'url' => 'http://google.com/', 'exists' => false],
        ['checker' => 'gateway', 'url' => 'http://undefined-undefined-undefined.com/', 'exists' => true],

        // Ok
        ['checker' => 'phpExtension', 'extension' => 'pdo', 'exists' => true],
        ['checker' => 'phpExtension', 'extension' => 'json', 'exists' => true],
        // Errors
        ['checker' => 'phpExtension', 'extension' => 'pdo', 'exists' => false],
        ['checker' => 'phpExtension', 'extension' => 'UNDEFINED', 'exists' => true],

        // Ok
        ['checker' => 'storagePdo',
         'connect' => ['dsn'  => 'mysql:host=127.0.0.1:3306;dbname=content',
                       'user' => 'user', 'password' => 'password'],
         'exists'  => true
        ],

        ['checker' => 'storagePdo',
         'connect' => ['dsn'  => 'mysql:host=127.0.0.1:3306;dbname=UNDEFINED',
                       'user' => 'UNDEFINED', 'password' => 'UNDEFINED'],
         'exists'  => false
        ],
        // Error
        ['checker' => 'storagePdo',
         'connect' => ['dsn'  => 'mysql:host=127.0.0.1:3306;dbname=content',
                       'user' => 'user', 'password' => 'password'],
         'exists'  => false
        ],
        ['checker' => 'storagePdo',
         'connect' => ['dsn'  => 'mysql:host=127.0.0.1:3306;dbname=UNDEFINED',
                       'user' => 'UNDEFINED', 'password' => 'UNDEFINED'],
         'exists'  => true
        ],
    ]
];