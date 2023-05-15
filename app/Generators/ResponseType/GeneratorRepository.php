<?php

namespace App\Generators\ResponseType;

use Illuminate\Support\Facades\File;
use Facades\App\Generators\ResponseType\ControllerTransformer;
use Facades\App\Generators\ResponseType\VueTransformer;
use Facades\App\Generators\ResponseType\RoutesTransformer;

class GeneratorRepository
{
    public string $name;
    public string $title;
    public string $description;
    protected string $key;

    public function setup(
        string $name,
        string $title,
        string $description,
        bool $requires_settings = false
    )
    {
        $this->name = $name;
        $this->requires_settings = $requires_settings;
        $this->title = $title;
        $this->description = $description;
        $this->key = str($name)->lower()->snake()->toString();

        return $this;
    }

    public function getKey() {
        return $this->key;
    }

    public function run()
    {
        ControllerTransformer::handle($this);
        VueTransformer::handle($this);
        RoutesTransformer::handle($this);

        return $this;
    }

    public function putFile(string $pathWithName, string $content)
    {
        File::put($pathWithName, $content);
    }

    public function getRootPathOrStubs(): string
    {
        return __DIR__.'/../../STUBS/';
    }
}
