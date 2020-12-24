<?php

it('has comment page - response test', function () {
    $this->get('/task/1/1')->assertStatus(200);
    actingAs(1)->get('/task/1/1')->assertStatus(200);
});
