<?php

namespace App\Jobs;

use App\Libs\Duplicates\Text;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Redis;
use App\Libs\Duplicates\DuplicatesOf;
use Illuminate\Queue\SerializesModels;
use App\Repositories\IArticleRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchDuplicates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const ARTICLES_PROCESSING_KEY = 'articles:procesing';

    private const HUNDRED_MILISECONDS = 0.1;

    private object $article;
    
    private float $expUnique;

    private IArticleRepository $articleRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(object $article)
    {
        $this->article           = $article;
        $this->articleRepository = app()->make(IArticleRepository::class);
        $this->expUnique         = env('DUPLICATION_UNIQUE_PERCENT', 95);
        $this->concurrencyCorrection();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $serialisedArticle = json_encode($this->article);
        Redis::sadd(self::ARTICLES_PROCESSING_KEY, $serialisedArticle);
        
        $duplicates = $this->findDuplicatesInProcessed();
        foreach($duplicates->array() as $duplicate) {
            $originalId = $duplicate->meta()['id'];
            $this->articleRepository->markAsDuplicate($originalId, $this->article->id);
        }

        $this->articleRepository->markAsProcessed($this->article->id);
        Redis::srem(self::ARTICLES_PROCESSING_KEY, $serialisedArticle);
    }

    private function concurrencyCorrection()
    {
        while(true) {
            $duplicates = $this->findDuplicatesInProcessing();
            if ($duplicates->exists()) {
                sleep(self::HUNDRED_MILISECONDS);
                continue;
            }
            return;
        }
    }

    private function findDuplicatesInProcessing()
    {
        $texts = collect(Redis::smembers(self::ARTICLES_PROCESSING_KEY))
                    ->transform(function($row) {
                        $row = json_decode($row);
                        return new Text($row->content, ['id' => $row->id]);
                    })
                    ->toArray();

        return new DuplicatesOf(
            new Text($this->article->content),
            $texts, 
            $this->expUnique
        );
    }

    private function findDuplicatesInProcessed()
    {
        $texts = $this->articleRepository
                      ->findAllOriginalsWthout($this->article->id)
                      ->transform(fn($row) => new Text($row->content, ['id' => $row->id]))
                      ->toArray();

        return new DuplicatesOf(
            new Text($this->article->content),
            $texts, 
            $this->expUnique
        );
    }
}
