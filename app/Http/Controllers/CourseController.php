<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCourseRequest;

class CourseController extends Controller
{
    public function create(CreateCourseRequest $request)
    {
        if (auth()->user()->cannot('create', Course::class)) {
            abort(403);
        }

        $course = Course::create(array_merge($request->all(), ['instructor_id' => auth()->user()->id]));

        return $course;
    }

    public function join(Course $course)
    {
        $course->users()->attach(auth()->user()->id);

        return response()->json(['message' => 'Join course successfully']);
    }

    public function delete(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return response()->json(['message' => 'Delete course successfully']);
    }
}
