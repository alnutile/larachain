<?php

namespace App\Generators\ResponseType;

class TokenReplacer
{
    public function handle(GeneratorRepository $generatorRepository, string $content): string
    {
        return str($content)
            ->replace([
                '[RESOURCE_PROPER]',
                '[RESOURCE_PROPER_PLURAL]',
                '[RESOURCE_SINGULAR_KEY]',
                '[RESOURCE_PLURAL_KEY]',
            ], [
                $generatorRepository->resource_proper,
                $generatorRepository->resource_proper_plural,
                $generatorRepository->resource_singular_key,
                $generatorRepository->resource_plural_key,
            ])->toString();
    }
}
