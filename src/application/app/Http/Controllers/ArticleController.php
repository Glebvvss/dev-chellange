<?php

namespace App\Http\Controllers;

use App\Entities\Article;
use Illuminate\Http\Request;
use App\Jobs\SearchDuplicates;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends Controller
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function all()
    {
        SearchDuplicates::dispatch();
        // find all articles
    }

    public function single()
    {
        // find single article by id
    }

    public function store()
    {
        // store new article
    }

    public function duplicates()
    {
        // find duplicate groups
    }
}
