<?php

namespace Bytesoft\Translation\Console;

use Bytesoft\Translation\Manager;
use Illuminate\Console\Command;

class FindCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cms:translations:find';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find translations in blade files';

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * FindCommand constructor.
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
     * @return int
     * @author Barry vd. Heuvel <barryvdh@gmail.com>
     */
    public function handle()
    {
        $counter = $this->manager->findTranslations(null);
        $this->info('Done importing, processed ' . $counter . ' items!');
    }
}
