<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Models\CommentThread;
use App\Http\Requests\CreateThreadRequest;
use App\Http\Requests\CreateCommentThreadRequest;

class ThreadController extends Controller
{
    public function index(Course $course)
    {
        $this->authorize('viewThreads', $course);

        return $course->threads()->get();
    }

    public function create(CreateThreadRequest $request, Course $course)
    {
        if ($request->user()->cannot('create', Thread::class)) {
            abort(403);
        }

        $thread = $course->threads()->create([
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ]);

        return $thread;
    }

    public function comment(CreateCommentThreadRequest $request, Course $course, Thread $thread)
    {
        $this->authorize('viewThreads', $course);

        $comment = CommentThread::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
        ]);

        return $comment;
    }

    public function deleteCommentThread(Course $course, Thread $thread, CommentThread $commentThread)
    {
        $user = auth()->user();
        $instructor = $course->instructor;

        if ($user->id === $commentThread->user_id || $user->id === $instructor->id) {
            $commentThread->delete();

            return response()->json(['message' => 'Delete comment thread successfully']);
        }

        return response()->json(['message' => 'Something went wrong']);
    }
}
