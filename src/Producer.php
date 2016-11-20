<?php

namespace Simplario\Checker;

use Simplario\Checker\Output\AbstractOutput;
use Simplario\Checker\Output\Console;
use Simplario\Checker\ResultException\AbstractResultException;
use Simplario\Checker\ResultException\ErrorException;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

class Producer
{

    const ERROR_CONFIG_WITH_EMPTY_TASK = 'Config with empty task';
    const PLACEHOLDER_TASK_SUCCESS = ' +    Ok :';
    const PLACEHOLDER_TASK_FAIL = ' -  Fail :';
    const PLACEHOLDER_TASK_ERROR = ' - Error :';

    protected $config = [];

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    protected $output;

    public function setOutput(AbstractOutput $output)
    {
        $this->output = $output;
        return $this;
    }

    public function getOutput()
    {

        if ($this->output === null) {
            $this->output = new Console();
        }

        return $this->output;
    }

    public function output($msg = '', $type = AbstractOutput::TYPE_DEFAULT)
    {
        $this->getOutput()->write($msg, $type);

        return $this;
    }

    public function run()
    {
        if (empty($this->config)) {
            $this->output(self::ERROR_CONFIG_WITH_EMPTY_TASK, AbstractOutput::TYPE_ERROR);

            return $this;
        }

        $this->renderHeader('Run checker');

        foreach ($this->config as $index => $task) {
            $resultException = $this->runTask($task);
            $this->renderTask($resultException);
        }

        $this->renderList($this->fail, 'Fail list');
        $this->renderList($this->error, 'Error list');
        $this->renderStats();

        return $this;
    }

    protected $checkerSet = [];

    public function createChecker($checkerAlias)
    {
        if (class_exists($checkerAlias)) {
            $class = $checkerAlias;
        } else {
            $class = __NAMESPACE__ . '\\Checker\\' . ucfirst($checkerAlias);
        }

        if (!isset($this->checkerSet[$class])) {
            $this->checkerSet[$class] = new $class;
        }

        return $this->checkerSet[$class];
    }

    protected $fail = [];
    protected $error = [];
    protected $success = [];

    protected function renderTask(AbstractResultException $resultException)
    {
        $result = 'undefined:';
        if ($resultException instanceof SuccessException) {
            $result = self::PLACEHOLDER_TASK_SUCCESS;
        } elseif ($resultException instanceof FailException) {
            $result = self::PLACEHOLDER_TASK_FAIL;
        } elseif ($resultException instanceof ErrorException) {
            $result = self::PLACEHOLDER_TASK_ERROR;
        }

        $this->output("{$result} {$resultException->getJson()}");

        return $this;
    }

    protected function renderHeader($text)
    {
        $this->output("");
        $this->output("=============================================================================");
        $this->output("=== {$text}");
        $this->output("=============================================================================");
        $this->output("");

        return $this;
    }

    protected function renderStats()
    {
        $fail = count($this->fail);
        $error = count($this->error);
        $success = count($this->success);
        $total = $error + $success + $fail;

        $imgPath = __DIR__ . '/../on-success.txt';
        if ($fail + $error === 0 && is_file($imgPath)) {
            $img = file_get_contents($imgPath);
            $this->output($img);
        }

        $this->renderHeader("Stats");
        $this->output(" > Total {$total}");
        $this->output(" > Success {$success}");
        $this->output(" > Fail {$fail}");
        $this->output(" > Error {$error}");

        return $this;
    }

    protected function renderList(array $list, $title = '')
    {

        if (count($list) === 0) {
            return $this;
        }

        $this->renderHeader($title);

        foreach ($list as $index => $resultException) {
            /** @var $error AbstractResultException */

            $text = implode(
                PHP_EOL, [
                    "# " . ($index + 1),
                    "  Checker : {$resultException->getChecker()}",
                    "  Task    : {$resultException->getJson()}",
                    "  Reason  : {$resultException->getMessage()}",
                    ""
                ]
            );

            $this->output($text);
        }

        return $this;
    }

    public function runTask(array  $task = [])
    {
        try {
            $checker = $this->createChecker($task['checker']);
            $checker->check($task);
        } catch (SuccessException $resultException) {
            $this->success[] = $resultException;
        } catch (FailException $resultException) {
            $this->fail[] = $resultException;
        } catch (ErrorException $resultException) {
            $this->error[] = $resultException;
        } catch (\Exception $ex) {
            $resultException = new ErrorException($ex->getMessage(), $task);;
            $this->error[] = $resultException;
        }

        if (empty($resultException)) {
            $resultException = new ErrorException('Checker fail to respond correct (((', $task);
        }

        return $resultException;
    }
}