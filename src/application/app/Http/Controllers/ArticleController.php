<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Jobs\SearchDuplicates;
use App\Repositories\IArticleRepository;
use Illuminate\Support\Facades\Response;

class ArticleController
{
    private IArticleRepository $articleRepository;
    private Response           $response;

    public function __construct(
        IArticleRepository $articleRepository,
        Response           $response
    )
    {
        $this->articleRepository = $articleRepository;
        $this->response          = $response;
    }

    public function all()
    {
        $duplicates = $this->articleRepository->findAllDuplicateIds();
        $articles   = $this->articleRepository->findAllOriginals();
        return $this->response::json(
            $articles->transform(fn($article) => [
                    'id'                    => $article->id,
                    'content'               => $article->content,
                    'duplicate_article_ids' => $duplicates->where('original_article_id', $article->id)
                                                          ->pluck('duplicate_article_id')
                                                          ->toArray()
                ])
                ->toArray()
        );
    }

    public function single(int $id)
    {
        if ($article = $this->articleRepository->findOne($id)) {
            return $this->response::json([
                'id'                    => $article->id,
                'content'               => $article->content,
                'duplicate_article_ids' => $this->articleRepository
                                                ->findDuplicateIdsOf($article->id)
            ]);
        }

        return $this->response::json(['error' => 'Article not found'], 404);
    }

    public function store(Request $request)
    {
        $content = @json_decode($request->getContent())->content;
        if (is_null($content)) {
            return $this->response::json(['error' => 'Incorrect provided data'], 400);
        }

        try {
            $article = $this->articleRepository->create($content);
            SearchDuplicates::dispatch($article);
            return $this->response::json(['id' => $article->id], 201);
        } catch (Exception $ex) {
            return $this->response::json(['error' => 'Unknown error'], 500);
        }
    }

    public function duplicates()
    {
        return $this->response::json([
            'duplicate_group_ids' => $this->articleRepository->findAllDuplicateGroupIds()
        ]);
    }
}