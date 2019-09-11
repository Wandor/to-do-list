<?php
use App\Task;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * Show Task Dashboard
 */
Route::get('/', function () 
{
    $tasks = Task::orderby('created_at', 'asc')->get();
    return view('tasks', 
                [
                    'tasks' => $tasks
                ]
                );
});
/**
 * Add New Task
 */
Route::post('/task', function (Request $request)
{
    $validator = Validator::make($request->all(), 
    [
        'name' => 'required|max:255',
    ]);
    if ($validator->fails())
    {
        return redirect ('/')
            ->withInput()
            ->withErrors($validator);
    }
    /**
     * Create a new task
     */
    $task = new Task;
    $task->name = $request->name;
    $task->save();
});
/**
 * Delete Task
 */
Route::delete('/task/{task}', function (Task $task)
{
    $task->delete();

    return redirect('/');
});