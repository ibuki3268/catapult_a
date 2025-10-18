<?php

namespace Tests\Feature;


use App\Models\User;
use App\Models\Task;

it('can add shared user to task', function () {
    $owner = User::factory()->create();
    $sharedUser = User::factory()->create();

    $this->actingAs($owner);

    $response = $this->post(route('share.create', ['user' => $sharedUser->id]));

    $response->assertRedirect();
    $this->assertDatabaseHas('task_share', [
        'user_id' => $owner->id,
        'shared_user_id' => $sharedUser->id,
    ]);
});
