<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\ControllerTransformer;
use Facades\App\Generators\ResponseType\EnumTransformer;
use Facades\App\Generators\ResponseType\LarachainConfigTransformer;
use Facades\App\Generators\ResponseType\ResponseTypeClassTransformer;
use Facades\App\Generators\ResponseType\RoutesTransformer;
use Facades\App\Generators\ResponseType\VueTransformer;
use Illuminate\Support\Facades\File;

class GeneratorRepository
{
    public string $name;

    public string $description;

    protected string $key;

    protected bool $requires_settings;

    protected string $class_name;

    public function setup(
        string $name,
        string $description,
        bool $requires_settings = false
    ) {
        $this->name = $name;
        $this->requires_settings = $requires_settings;
        $this->description = $description;
        $this->class_name = str($name)->studly()->toString();
        $this->key = str($name)->lower()->snake()->toString();

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getClassName(): string
    {
        return $this->class_name;
    }

    public function run()
    {
        ControllerTransformer::handle($this);
        VueTransformer::handle($this);
        RoutesTransformer::handle($this);
        EnumTransformer::handle($this);
        LarachainConfigTransformer::handle($this);
        ResponseTypeClassTransformer::handle($this);

        return $this;
    }

    public function putFile(string $pathWithName, string $content)
    {
        File::put($pathWithName, $content);
    }

    public function getRootPathOrStubs(): string
    {
        return base_path('STUBS/');
    }
}
