<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn($user, $id): bool => (int) $user->id === (int) $id);

Broadcast::channel('alert-maintenance-channel', fn() => auth()->check());

Broadcast::channel('daily-usages', fn() => auth()->check());
