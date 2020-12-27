<?php

use function Tests\actingAs;

it('has keyboard shortcuts page - response test', function () {
    $this->get('/site/shortcuts')->assertStatus(302);
    actingAs(1)->get('/site/shortcuts')->assertStatus(200);
});
