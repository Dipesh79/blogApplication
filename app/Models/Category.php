<?php

namespace App\Models;

use Dipesh79\LaravelHelpers\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Filterable, HasFactory;

    protected $fillable = ['name', 'slug'];

    protected array $filterable = ['name', 'slug'];

}
