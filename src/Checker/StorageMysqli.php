<?php

namespace Simplario\Checker\Checker;

class StorageMysqli extends StoragePdo
{
    /**
     * @var string
     */
    protected $target = 'connect';

    /**
     * @param array $connect
     *
     * @return \mysqli
     * @throws \Exception
     */
    protected function createInstance(array $connect)
    {
        $instance = mysqli_connect(
            isset($connect['host']) ? $connect['host'] : '127.0.0.1',
            isset($connect['user']) ? $connect['user'] : '',
            isset($connect['password']) ? $connect['password'] : '',
            isset($connect['database']) ? $connect['database'] : '',
            isset($connect['port']) ? $connect['port'] : 3306,
            isset($connect['socket']) ? $connect['socket'] : ''
        );

        if (!$instance) {
            throw new \Exception("Unable to connect to MySQL. " . mysqli_connect_error());
        }

        return $instance;
    }

}
