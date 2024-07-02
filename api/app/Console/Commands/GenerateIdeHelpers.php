<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateIdeHelpers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:ide-helpers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate IDE helper files for better autocompletion in IDEs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Generating IDE helper files...');

        Artisan::call('ide-helper:generate');
        $this->info('Generated ide-helper.php');

        Artisan::call('ide-helper:meta');
        $this->info('Generated .phpstorm.meta.php');

        Artisan::call('ide-helper:models', ['--nowrite' => true]);
        $this->info('Generated _ide_helper_models.php');

        $this->info('IDE helper files generated successfully.');

        return 0;
    }
}
