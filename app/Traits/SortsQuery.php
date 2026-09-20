<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Sort server-side dari ?sort=kolom&dir=asc|desc (dipakai tabel paginasi;
 * header <th data-sort="kolom"> di view, lihat resources/js/table-tools.js).
 */
trait SortsQuery
{
    /**
     * @param  array<string,string>  $allowed  ['kunci_th' => 'kolom_db'] — whitelist, cegah injeksi kolom
     */
    protected function applySort(Builder $query, Request $request, array $allowed): Builder
    {
        $kolom = $allowed[$request->get('sort')] ?? null;
        if (!$kolom) {
            return $query;
        }

        $dir = $request->get('dir') === 'desc' ? 'desc' : 'asc';

        // Sort eksplisit menggantikan urutan default (latest/orderBy) dari controller
        $query->reorder($kolom, $dir);

        return $query;
    }
}
