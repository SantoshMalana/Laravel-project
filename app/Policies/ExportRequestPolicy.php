<?php

namespace App\Policies;

use App\Models\ExportRequest;
use App\Models\User;

class ExportRequestPolicy
{
    public function view(User $user, ExportRequest $exportRequest): bool
    {
        return $user->id === $exportRequest->user_id
            || in_array($user->role, ['admin', 'staff']);
    }
}
