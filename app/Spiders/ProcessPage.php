<?php

namespace App\Spiders;

use App\Jobs\SaveItemToDocumentsTableJob;
use Illuminate\Support\Str;
use RoachPHP\ItemPipeline\ItemInterface;

class ProcessPage implements \RoachPHP\ItemPipeline\Processors\ItemProcessorInterface
{

    public function configure(array $options): void
    {
        // TODO: Implement configure() method.
    }

    public function processItem(ItemInterface $item): ItemInterface
    {
        /**
         * @TODO
         * how to abstract this out more as well
         * could be a batch
         * save to db
         * then batch
         *
         */
        SaveItemToDocumentsTableJob::dispatch(
            $item->get("content"),
            $item->get("uri"),
            "project_id_" . Str::random(),
            [
                'Maker',
                'Culture',
                'Title',
                'Date Made',
                'Materials',
                'Measurements',
                'Accession Number',
                'Museum Collection',
                'Label Text',
                'Tags',
            ]
        );
    }
}
