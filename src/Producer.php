<?php

namespace Simplario\Checker;

use Simplario\Checker\Checker\AbstractChecker;
use Simplario\Checker\Output\AbstractOutput;
use Simplario\Checker\Output\Console;
use Simplario\Checker\ResultException\AbstractResultException;
use Simplario\Checker\ResultException\ErrorException;
use Simplario\Checker\ResultException\FailException;
use Simplario\Checker\ResultException\SuccessException;

/**
 * Class Producer
 *
 * @package Simplario\Checker
 */
class Producer
{

    const ERROR_CONFIG_WITH_EMPTY_TASK = 'Config with empty task';
    const PLACEHOLDER_TASK_SUCCESS = ' +    Ok :';
    const PLACEHOLDER_TASK_FAIL = ' -  Fail :';
    const PLACEHOLDER_TASK_ERROR = ' - Error :';

    /**
     * @var array
     */
    protected $taskSet = [];

    /**
     * @var AbstractChecker[]
     */
    protected $checkerSet = [];

    /**
     * @var AbstractOutput
     */
    protected $outputHandler;

    /**
     * @var array
     */
    protected $taskFail = [];

    /**
     * @var array
     */
    protected $taskError = [];

    /**
     * @var array
     */
    protected $taskSuccess = [];

    /**
     * Producer constructor.
     *
     * @param array $taskSet
     */
    public function __construct(array $taskSet = [])
    {
        $this->setTaskSet($taskSet);
    }

    /**
     * @param array $taskSet
     *
     * @return $this
     */
    public function setTaskSet(array $taskSet)
    {
        $this->taskSet = $taskSet;

        return $this;
    }

    /**
     * @param AbstractOutput $outputHandler
     *
     * @return $this
     */
    public function setOutputHandler(AbstractOutput $outputHandler)
    {
        $this->outputHandler = $outputHandler;

        return $this;
    }

    /**
     * @return AbstractOutput|Console
     */
    public function getOutputHandler()
    {
        if ($this->outputHandler === null) {
            $this->outputHandler = new Console();
        }

        return $this->outputHandler;
    }

    /**
     * @param string $msg
     * @param string $type
     *
     * @return $this
     */
    public function output($msg = '', $type = AbstractOutput::TYPE_DEFAULT)
    {
        $this->getOutputHandler()->write($msg, $type);

        return $this;
    }

    /**
     * @return $this
     */
    public function run()
    {
        if (empty($this->taskSet)) {
            $this->output(self::ERROR_CONFIG_WITH_EMPTY_TASK, AbstractOutput::TYPE_ERROR);

            return $this;
        }

        $this->renderHeader('Run checker');

        foreach ($this->taskSet as $index => $task) {
            $resultException = $this->runTask($task);
            $this->renderTask($resultException);
        }

        $this->renderList($this->taskFail, 'Fail list');
        $this->renderList($this->taskError, 'Error list');
        $this->renderStats();

        return $this;
    }

    /**
     * @param $checkerAlias
     *
     * @return AbstractChecker
     */
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

    /**
     * @param AbstractResultException $resultException
     *
     * @return $this
     */
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

    /**
     * @param $text
     *
     * @return $this
     */
    protected function renderHeader($text)
    {
        $this->output("");
        $this->output("=============================================================================");
        $this->output("=== {$text}");
        $this->output("=============================================================================");
        $this->output("");

        return $this;
    }

    /**
     * @return $this
     */
    protected function renderStats()
    {
        $fail = count($this->taskFail);
        $error = count($this->taskError);
        $success = count($this->taskSuccess);
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

    /**
     * @param array  $list
     * @param string $title
     *
     * @return $this
     */
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

    /**
     * @param array $task
     *
     * @return \Exception|ErrorException|FailException|SuccessException
     */
    public function runTask(array  $task = [])
    {
        try {
            $checker = $this->createChecker($task['checker']);
            $checker->check($task);
        } catch (SuccessException $resultException) {
            $this->taskSuccess[] = $resultException;
        } catch (FailException $resultException) {
            $this->taskFail[] = $resultException;
        } catch (ErrorException $resultException) {
            $this->taskError[] = $resultException;
        } catch (\Exception $ex) {
            $resultException = new ErrorException($ex->getMessage(), $task);;
            $this->taskError[] = $resultException;
        }

        if (empty($resultException)) {
            $resultException = new ErrorException('Checker fail to respond correct (((', $task);
        }

        return $resultException;
    }
}