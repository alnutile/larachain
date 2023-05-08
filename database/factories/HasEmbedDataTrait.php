<?php

namespace Database\Factories;

trait HasEmbedDataTrait
{
    public function withEmbedData()
    {

        return $this->state(function (array $attributes) {
            $embeddings = get_fixture('embedding_response.json');

            return [
                'embedding' => data_get($embeddings, 'data.0.embedding'),
            ];
        });
    }
}
