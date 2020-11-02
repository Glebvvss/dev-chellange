<?php

namespace App\Repositories;

use DB;
use Exception;

class ArticleRepository implements IArticleRepository
{
    public function create(string $content): object
    {
        $id = DB::table('articles')->insertGetId(['content' => $content]);

        if (empty($id)) {
            throw new Exception('Article not stored to db');
        }

        return DB::table('articles')->where('id', '=', $id)->first();
    }

    public function markAsDuplicate(int $originalId, int $duplicateId): void
    {
        DB::table('articles_duplicates')->insert([
            'original_article_id'  => $originalId, 
            'duplicate_article_id' => $duplicateId
        ]);

        DB::table('articles')->where('id', '=', $duplicateId)->update(['is_duplicate' => 1]);
    }

    public function markAsProcessed(int $id): void
    {
        DB::table('articles')->where('id', '=', $id)->update(['is_processed' => 1]);
    }

    public function findAllOriginals(): object
    {
        return DB::table('articles')
                ->where('is_duplicate', '=', 0)
                ->where('is_processed', '=', 1)
                ->get();
    }

    public function findOne(int $id): object
    {
        return DB::table('articles')->where('id', '=', $id)->first();
    }

    public function findAllDuplicateIds(): object
    {
        return DB::table('articles_duplicates')
                ->orderBy('duplicate_article_id')
                ->get();
    }

    public function findAllOriginalsWthout(int $id): object
    {
        return DB::table('articles')
                ->where('is_duplicate', '=', 0)
                ->where('is_processed', '=', 1)
                ->where('id', '<>', $id)
                ->get();
    }

    public function findDuplicateIdsOf(int $id): array
    {
        return DB::table('articles_duplicates')
                ->where('original_article_id', $id)
                ->orderBy('duplicate_article_id')
                ->get()
                ->pluck('duplicate_article_id')
                ->toArray();
    }

    public function findAllDuplicateGroupIds(): array
    {
        return DB::table('articles_duplicates')
                ->select(['original_article_id'])
                ->groupBy('original_article_id')
                ->get()
                ->pluck('original_article_id')
                ->toArray();
    }
}