<?php

namespace App\Actions;

use App\Gamify\Points\TaskCreated;
use Illuminate\Support\Arr;
use App\Models\Product;

class PostTaskForProductLaunch
{
    /** @var Product $product */
    protected Product $product;

    /**
     * Inject products to post.
     *
     * @param \App\Models\Product $product Product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Select random task to post on product launch.
     *
     * @return void
     */
    public function __invoke()
    {
        $randomTask = Arr::random(config('taskord.tasks.templates'));

        $task = (new CreateNewTask(
            auth()->user(), [
                'product_id' => $this->product->id,
                'task' => sprintf($randomTask, $this->product->name),
                'done' => true,
                'done_at' => $this->product->launched_at,
                'type' => 'product',
            ]
        ))();

        givePoint(new TaskCreated($task));
    }
}
