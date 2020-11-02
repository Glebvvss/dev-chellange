<?php

namespace App\Repositories;

interface IArticleRepository
{
    public function create(string $content): object;

    public function markAsDuplicate(int $originalId, int $duplicateId): void;

    public function markAsProcessed(int $id): void;

    public function findAllOriginals(): object;

    public function findOne(int $id): object;

    public function findAllDuplicateIds(): object;

    public function findAllOriginalsWthout(int $id): object;

    public function findDuplicateIdsOf(int $id): array;

    public function findAllDuplicateGroupIds(): array;
}