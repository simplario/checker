<?php

return [
    'tasks' => [
        ['checker' => 'filesystem', 'path' => __FILE__, 'exists' => true, 'readable' => true],
        ['checker' => Simplario\Checker\Checker\Filesystem::class, 'path' => __FILE__, 'exists' => true, 'readable' => true],
    ],
];
