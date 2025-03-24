<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ChecksOwnership
{
    /**
     * Check if the authenticated user owns the given model.
     *
     * @param  Model  $model
     * @return bool
     */
    public function isOwner(Model $model): bool
    {
        return $model->user_id === Auth::id();
    }

    /**
     * Check if the authenticated user owns the given model and return 403 if not.
     *
     * @param  Model  $model
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function authorizeOwner(Model $model)
    {
        if (!$this->isOwner($model)) {
            return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
        }

        return null;
    }
}