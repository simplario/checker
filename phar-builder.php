#!/usr/bin/env php
<?php

$phar = new Phar('checker.phar', 0, 'checker.phar');
// start buffering. Mandatory to modify stub.
$phar->startBuffering();

// Get the default stub. You can create your own if you have specific needs
$defaultStub = $phar->createDefaultStub('checker');

// Adding files
$phar->buildFromDirectory(__DIR__);
// $phar->buildFromDirectory(__DIR__, '/\.php$/');

// Create a custom stub to add the shebang
// $stub = "#!/usr/bin/env php \n".$defaultStub;
$stub = "#!/usr/bin/env php \n".$defaultStub;

// Add the stub
$phar->setStub($stub);

$phar->stopBuffering();

echo "checker.phar archive has been saved" . PHP_EOL;
