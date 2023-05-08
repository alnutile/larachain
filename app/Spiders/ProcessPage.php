<?php

namespace App\Spiders;

use App\Data\DataToDocumentDtoData;
use App\Jobs\SaveItemToDocumentsTableJob;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\Support\Configurable;

class ProcessPage implements \RoachPHP\ItemPipeline\Processors\ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        /**
         * @TODO
         * how to abstract this out more as well
         * could be a batch
         * save to db
         * then batch
         */
        SaveItemToDocumentsTableJob::dispatch(
            new DataToDocumentDtoData(
                $item->get('content'),
                $item->get('uri'),
                $item->get('source_id'))
        );

        return $item;
    }
}
