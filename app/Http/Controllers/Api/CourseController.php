<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Resources\Api\CourseResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CourseResource::collection(Course::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $user = User::find($id);
        
        $file = $request->file("image");
        $file_name = $file->hashName();
        Storage::disk('public')->putFileAs("courses",$file,$file_name);

        $course = new Course([
            "name" => $request->name,
            "url_image" => $file_name,
            "description" => $request->description,
        ]);
        $course = $user->courses()->save($course);
        return new CourseResource($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $file = $request->file("image");
        $file_name = $file->hashName();
        if( Storage::disk('public')->exists("courses/".$course->url_image)){
            Storage::disk('public')->delete("courses/".$course->url_image);
        }
        
        Storage::disk('public')->putFileAs("courses",$file,$file_name);

        $course->name = $request->name;
        $course->description = $request->description;
        $course->url_image = $file_name;

        $course->save();
        return new CourseResource($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
