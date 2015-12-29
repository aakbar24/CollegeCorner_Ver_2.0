<?php
class MigrationTool
{

    public static function runMigration($type = null)
    {
        $entryScript = 'yiic';
        $command = 'migrate';
        $interactive = '--interactive=0';

        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
        $runner->addCommands($commandPath);

        $args = array($entryScript, $command);
        if ($type !== null) $args[] = $type;
        $args[] = $interactive;

        ob_start();
        $runner->run($args);

        $return = htmlentities(ob_get_clean(), null, Yii::app()->charset);

        Yii::app()->user->setFlash('results', $return);
    }

}