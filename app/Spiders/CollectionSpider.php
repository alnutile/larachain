<?php

namespace App\Spiders;

use App\Models\Source;
use Generator;
use Illuminate\Support\Collection;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class CollectionSpider extends ItemSpider
{
    public Collection $links;

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /** @return Request[] */
    protected function initialRequests(): array
    {
        return [
            new Request(
                'GET',
                'https://museums.fivecolleges.edu/info.php?f=option7&type=browse&t=objects&s=abstract',
                [$this, 'parseOverview']
            ),
        ];
    }

    public function parseOverview(Response $response): Generator
    {
        $this->source = Source::findOrFail($this->context['source_id']);

        $this->links = collect([]);

        $response->filterXPath('//html/body/div[1]/div[3]/table[2]')
            ->each(function (Crawler $node) {
                $rows = $node->filter('tr');
                $rows->each(function (Crawler $row) {
                    $cells = $row->filter('td > a');
                    $cells->each(function (Crawler $cell) {
                        $this->links->add($cell->link()->getUri());
                    });
                });
            });

        foreach ($this->links->unique()->values()->toArray() as $url) {
            yield $this->request('GET', $url);
        }
    }
}
