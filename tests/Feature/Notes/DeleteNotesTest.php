<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use App\Models\Note;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_delete_note()
    {
        $note = Note::create([
            "title" => "Note title",
            "content" => "Note content"
        ]);

        $response = $this->deleteJson( route("api.v1.notes.destroy", $note->getRouteKey()), [], [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(204);
    }

    /** @test */
    public function test_can_not_found_note_to_delete(){

        $noteId = 1;

        $response = $this->deleteJson( route("api.v1.notes.destroy", $noteId), [], [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(404)
            ->assertExactJson([
                "errors" => [
                    "status" => "404",
                    "title" => "Not Found",
                    "detail" => "Note with id {$noteId} was not found.",
                    "source" => [
                        "pointer" => "id"
                    ]
                ]
            ]);
    }

    public function test_can_not_delete_note_without_content_type_header(){
        $note = Note::create([
            "title" => "Note title",
            "content" => "Note content"
        ]);

        $response = $this->deleteJson( route("api.v1.notes.destroy", $note->getRouteKey()) );

        $response
            ->assertStatus(406)
            ->assertExactJson([
                "errors" => [
                    "status" => "406",
                    "title" => "Not Acceptable",
                    "detail" => "You must include Content-Type header with 'application/vnd.api+json' value.",
                    "source" => [
                        "pointer" => "Content-Type Header"
                    ]
                ]
            ]);
    }
}
