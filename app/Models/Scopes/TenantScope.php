<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();

        // Super admins see all data across tenants
        if ($user->isSuperAdmin()) {
            return;
        }

        // Users without a tenant get an empty result instead of every tenant's data
        $builder->where($model->getTable().'.tenant_id', $user->tenant_id);
    }
}
