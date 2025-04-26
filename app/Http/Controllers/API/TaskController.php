<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Jobs\ProcessTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Add a Submit Task new task.
     */
    public function submitTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer|min:1|max:1000000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation Error',
                'messages' => $validator->errors()
            ], 422);
        }

        $task = Task::create([
            'input_data' => $request->only('number'),
        ]);

        dispatch(new ProcessTask($task));

        return response()->json([
            'task_id' => $task->task_id,
            'status' => $task->status,
        ], 202); // 202 Accepted
    }

    /**
     * Get task status by task_id.
     */
    public function fetchTaskStatus($task_id)
    {
        //echo $task_id;
        $task = Task::where('task_id', $task_id)->first();

        if (!$task) {
            return response()->json([
                'error' => 'Task Not Found'
            ], 404);
        }

        return response()->json([
            'status' => $task->status,
            'result'=> $task->result,
            'created_at' => $task->created_at
        ]);

    }

    /**
     * Get task result by task_id.
     */
    public function fetchTaskResult($task_id)
    {
        $task = Task::where('task_id', $task_id)->first();

        if (!$task) {
            return response()->json([
                'error' => 'Task Not Found'
            ], 404);
        }

        if ($task->status !== 'completed') {
            return response()->json([
                'error' => 'Task not completed yet.',
                'status' => $task->status,
            ], 409); // Conflict
        }

        return response()->json([
            'task_id' => $task->task_id,
            'result' => $task->result,
        ]);
    }
}
