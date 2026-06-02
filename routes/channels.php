<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('teknisi.{id_teknisi}', function ($user, $id_teknisi) {
    // Karena kamu memakai guard 'teknisi', pastikan auth-nya cocok
    return (int) $user->id_teknisi === (int) $id_teknisi;
}, ['guards' => ['teknisi']]);