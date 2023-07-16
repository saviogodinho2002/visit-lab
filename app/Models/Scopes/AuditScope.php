<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AuditScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(!auth()->user()->hasRole("admin")){
            $builder->whereHas("user",function (Builder $query){
               $query->where("laboratory_id","=",auth()->user()->laboratory_id);
            });
        }
    }
}
