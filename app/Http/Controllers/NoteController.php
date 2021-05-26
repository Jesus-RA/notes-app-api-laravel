<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Http\Resources\NoteCollection;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NoteCollection::make(Note::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {
        if($request->validator->fails()){
            return response()->json([
                "errors" => [
                    "status" => "403",
                    "title" => "Forbidden",
                    "detail" => "Request format, invalid. You must follow JsonAPI Specification to create a resource.",
                    "source" => [
                        "pointer" => "Request format"
                    ]
                ]
            ], 403);
        }

        $note = Note::create([
            "title" => $request->data["attributes"]["title"],
            "content" => $request->data["attributes"]["content"]
        ]);

        return NoteResource::make($note)
            ->response(null, 201)
            ->header("Location", route( "api.v1.notes.show", $note->getRouteKey()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($noteId)
    {
        $note = Note::find($noteId);

        if ($note === null)
            return response()->json([
                "errors" => [
                    "status" => "404",
                    "title" => "Not Found",
                    "detail" => "Note with id {$noteId} was not found.",
                    "source" => [
                        "pointer" => "id"
                    ]
                ]
            ], 404);

        return NoteResource::make($note);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return NoteResource::make($note)->response(null, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(NoteRequest $request, Note $note)
    {

        $note->update($request->data["attributes"]);

        return NoteResource::make($note)
                ->response(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($noteId)
    {
        $note = Note::find($noteId);

        if($note === null)
            return response()->json([
                "errors" => [
                    "status" => "404",
                    "title" => "Not Found",
                    "detail" => "Note with id {$noteId} was not found.",
                    "source" => [
                        "pointer" => "id"
                    ]
                ]
            ], 404);

        $note->delete();

        return response()->json(null, 204);
    }
}
