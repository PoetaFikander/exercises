<?php


namespace App\Repositories;

use App\Models\Agreement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgreementRepository extends BaseRepository
{
    public function __construct(Agreement $model)
    {
        $this->model = $model;
    }

}
