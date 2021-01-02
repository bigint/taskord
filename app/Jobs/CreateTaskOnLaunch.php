<?php

namespace App\Jobs;

use App\Actions\CreateNewTask;
use App\Gamify\Points\TaskCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class CreateTaskOnLaunch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Product $product;
    protected User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $randomTask = Arr::random(config('taskord.tasks.templates'));

        $task = (new CreateNewTask(
            $this->user, [
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
