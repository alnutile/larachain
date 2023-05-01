<?php

namespace Tests\Feature;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Tests\TestCase;

class ClientWrapperTest extends TestCase
{
    public function test_chat()
    {

        $response = ClientWrapper::chat(
            [
                [
                    'role' => 'system',
                    'content' => 'You are an AI Historian assistant...',
                ],
                [
                    'role' => 'user',
                    'content' => "What other makers are around the time of O'Keeffe, Georgia?",
                ],
                [
                    'role' => 'assistant',
                    'content' => 'yup',
                ],
                [
                    'role' => 'user',
                    'content' => "What influenced O'Keeffe's art style?",
                ],
            ]
        );

        $this->assertNotNull($response);

    }

    public function test_embeddings()
    {

        $fixture = <<<'EOL'
Maker: O'Keeffe, Georgia
Culture: American (1887-1986)
Title: Red Snapdragons
Date Made: ca. 1923
Materials: oil on canvas
Measurements: whole: 20 1/4 x 10 1/4 in.; 51.435 x 26.035 cm
Accession Number: AC 1.1990
Museum Collection: Mead Art Museum at Amherst College (https://www.amherst.edu/museums/mead)

Label Text: O’Keeffe is considered a pioneer of American modernism. She was among the earliest artists in the United States to explore abstraction, developing her own style that centered on the precise use of line, natural forms, and distinctions of color. In 1915 the acclaimed photographer Alfred Stieglitz (American, 1864–1946) debuted her abstract charcoal drawings at his vanguard 291 gallery in New York, proclaiming, “Finally, a woman on paper.” O’Keeffe, however, did not remain “on paper” and soon began to create oil paintings, including Red Snapdragons. In 1946 she became the first woman to have a major solo exhibition at the Museum of Modern Art, where she was praised for her “highly individual artistic expression.” Lisa Crossman, 2020

Tags: flowers; abstract; symbolism
EOL;

    $response = ClientWrapper::getEmbedding($fixture);

    $this->assertInstanceOf(EmbeddingsResponseDto::class, $response);

    }
}
