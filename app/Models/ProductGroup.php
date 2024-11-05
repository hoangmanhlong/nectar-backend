<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    const ID = 'id';

    const NAME = 'name';

    const PRODUCTS = 'products';

    const PRODUCT_ID = 'product_id';

    public int $id;

    public string $name;

    public array $products;

    public function __construct(int $id, string $name, array $products)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = $products;
    }
}
