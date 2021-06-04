<?php

namespace PixelBoii\Vague\Console;

use Illuminate\Console\GeneratorCommand;

class MakeResource extends GeneratorCommand
{
    protected $name = 'vague:resource';

    protected $description = 'Create a new Vague resource';

    protected $type = 'Vague';

    protected function getStub()
    {
        return __DIR__ . '/stubs/Resource.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Vague';
    }

    public function handle()
    {
        parent::handle();
    }
}