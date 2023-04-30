<?php

namespace App\LLMModels\OpenAi;

use Illuminate\Support\Arr;
use OpenAI\Laravel\Facades\OpenAI;

class ClientWrapper
{
    protected int $tokens = 2000;

    protected string $size = '512x512';

    protected float $temperature = 0.1;

    public function setSize(string $size)
    {
        $this->size = $size;

        return $this;
    }

    public function setTemperature(float $temp)
    {
        $this->temperature = $temp;

        return $this;
    }

    public function setTokens(int $token)
    {
        $this->tokens = $token;

        return $this;
    }

    public function getEmbedding(string $content): EmbeddingsResponseDto
    {
        if (config('openai.mock')) {
            $data = get_fixture('embedding_response.json');

            return new EmbeddingsResponseDto(
                data_get($data, 'data.0.embedding'),
                1000,
            );
        }

        $response = OpenAI::embeddings()->create([
            'model' => 'text-similarity-babbage-001',
            'input' => $content,
        ]);

        $embeddings = Arr::first($response->embeddings);

        return new EmbeddingsResponseDto(
            $embeddings,
            $response->usage->totalTokens,
        );

    }

    public function generateTldr($content): string
    {
        if (config('openai.mock')) {
            $data = get_fixture('chapter_response.json');

            return data_get($data, 'choices.0.text');
        }

        $prompt = <<<'EOD'
Can you give me a tldr of this content keeping it under 1000 characters
%s

##


EOD;

        $prompt = sprintf($prompt, $content);

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => $this->tokens,
            'temperature' => $this->temperature,
        ]);

        $context = data_get($result, 'choices.0.text');

        return $context;
    }

    public function generateImage($prompt): string
    {
        if (config('openai.mock')) {
            $data = get_fixture('image_response.json');

            return data_get($data, 'data.0.url');
        }

        $result = OpenAI::images()->create([
            'prompt' => $prompt,
            'n' => 1,
            'size' => $this->size,
        ]);

        $content = data_get($result, 'data.0.url');

        return $content;
    }

    public function completions($prompt): string
    {
        if (config('openai.mock')) {
            $data = get_fixture('chapter_response.json');

            return data_get($data, 'choices.0.text');
        }

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => $this->tokens,
            'temperature' => $this->temperature,
        ]);

        $context = data_get($result, 'choices.0.text');

        return $context;
    }
}
