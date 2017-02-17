<?php

namespace AppBundle\Composer;

use Composer\Script\CommandEvent;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as BaseScriptHandler;

class DatabaseMigrationHandler extends BaseScriptHandler
{
    public static function migrate(CommandEvent $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'create database');

        if (null === $consoleDir) {
            return;
        }

        static::executeCommand(
            $event,
            $consoleDir,
            'doctrine:database:create --if-not-exists',
            $options['process-timeout']
        );

        static::executeCommand(
            $event,
            $consoleDir,
            'doctrine:migrations:migrate -n',
            $options['process-timeout']
        );
    }
}
