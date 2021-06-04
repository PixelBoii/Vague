<?php

namespace PixelBoii\Vague\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallPackage extends Command
{
    protected $signature = 'vague:install';

    protected $description = 'Install the Vague package';

    public function handle()
    {
        $this->info('Installing Vague...');

        /**
         * Publish config
         */
        $this->info('Publishing configuration...');

        if (!File::exists(config_path('vague.php'))) {
            $this->publish('config');
        } else {
            if ($this->shouldOverwrite('Config')) {
                $this->info('Overwriting configuration file...');
                $this->publish('config', true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        /**
         * Publish Public Folder
         */
        $this->info('Publishing public files...');

        if (!File::exists(public_path('vendor/vague'))) {
            $this->publish('public');
        } else {
            if ($this->shouldOverwrite('Public Folder')) {
                $this->info('Overwriting public folder...');
                $this->publish('public', true);
            } else {
                $this->info('Existing files were not overwritten');
            }
        }

        /**
         * Publish Base Template
         */
        $this->info('Publishing base files...');

        if (!File::exists(app_path('Vague'))) {
            $this->publish('base');
        } else {
            if ($this->shouldOverwrite('Base Files')) {
                $this->info('Overwriting base files...');
                $this->publish('base', true);
            } else {
                $this->info('Existing files were not overwritten');
            }
        }

        $this->info('Finished installation, go build something!');
    }

    private function shouldOverwrite($tag)
    {
        return $this->confirm(
            $tag . ' file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publish($tag, $forcePublish = false)
    {
        $params = [
            '--provider' => "PixelBoii\Vague\VagueServiceProvider",
            '--tag' => $tag
        ];

        if ($forcePublish === true) {
            $params['--force'] = '';
        }

        $this->call('vendor:publish', $params);
    }
}