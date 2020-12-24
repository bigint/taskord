<?php

it('has task page - response test', function () {
    $this->get('/task/1')->assertStatus(200);
    actingAs(1)->get('/task/1')->assertStatus(200);
});
