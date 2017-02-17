<?php

namespace Tests\AppBundle;

use Behat\Symfony2Extension\Context\KernelAwareContext;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\AppBundle\Dictionary\KernelAwareDictionaryTrait;

class ConsoleContext implements KernelAwareContext
{
    use KernelAwareDictionaryTrait;

    private $lastCommandOutput = '';

    /**
     * @When I run command :name
     */
    public function iRunCommand(string $name)
    {
        $tester = $this->getCommandTester($name);
        $tester->execute([]);

        $this->lastCommandOutput = $tester->getDisplay();
    }

    /**
     * @Then I should see command response :expectedOutput
     *
     * @throws ExpectationFailedException
     */
    public function iShouldSeeCommandResponse(string $expectedOutput)
    {
        Assert::assertEquals($this->lastCommandOutput, $expectedOutput);
    }

    private function getCommandTester(string $commandName): CommandTester
    {
        $command = $this->getContainer()->get($commandName);

        return new CommandTester($command);
    }
}
