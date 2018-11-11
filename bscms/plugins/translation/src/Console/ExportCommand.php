<?php

namespace Bytesoft\Translation\Console;

use Bytesoft\Translation\Manager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ExportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms:translations:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export translations to PHP files';

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * ExportCommand constructor.
     * @param Manager $manager
     * @author Barry vd. Heuvel <barryvdh@gmail.com>
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @author Barry vd. Heuvel <barryvdh@gmail.com>
     */
    public function handle()
    {
        $group = $this->argument('group');
        $json = $this->option('json');

        if (empty($group) && !$json) {
            $this->warn('You must either specify a group argument or export as --json');

            return;
        }

        if (!empty($group) && $json) {
            $this->warn('You cannot use both group argument and --json option at the same time');

            return;
        }

        $this->manager->exportTranslations($group, $json);

        if (!empty($group)) {
            $this->info('Done writing language files for ' . (($group == '*') ? 'ALL groups' : $group . ' group'));
        } elseif ($json) {
            $this->info('Done writing JSON language files for translation strings');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     * @author Barry vd. Heuvel <barryvdh@gmail.com>
     */
    protected function getArguments()
    {
        return [
            ['group', InputArgument::OPTIONAL, 'The group to export (`*` for all).'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['json', 'J', InputOption::VALUE_NONE, 'Export anonymous strings to JSON'],
        ];
    }
}