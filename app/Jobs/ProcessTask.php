<?php

namespace App\Jobs;

use App\Models\Task;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTask implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Update task status to 'processing'
        $this->task->update([
            'status' => 'processing',
        ]);

        try {
            // Process the task
            $input = $this->task->input_data['number'] ?? 10000;
            $result = array_sum(range(1, $input));

            // Update task status to 'completed' with result
            $this->task->update([
                'status' => 'completed',
                'result' => $result,
            ]);
        } catch (Exception $e) {
            // In case of error, update task as 'failed'
            $this->task->update([
                'status' => 'failed',
                'result' => $e->getMessage(),
            ]);
        }
    }
}
