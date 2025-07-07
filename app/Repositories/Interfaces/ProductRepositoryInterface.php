<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function findByOne(int $product_id);
    public function getIdAndName();
    public function create(array $data);
    public function update(array $data, int $product_id);
    public function destroy(int $product_id);
}
