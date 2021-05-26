<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use App\Models\Note;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_fetch_note_data_to_edit(){

        $note = Note::create([
            "title" => "Note original title",
            "content" => "Note original content"
        ]);

        $response = $this->getJson( route("api.v1.notes.edit", $note->getRouteKey()), [
            "Content-Type" => "application/vnd.api+json"
        ] );

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data" => [
                    "type" => "notes",
                    "id" => (string) $note->getRouteKey(),
                    "attributes" => [
                        "title" => $note->title,
                        "content" => $note->content,
                        "created_at" => $note->created_at
                    ],
                    "links" => [
                        "self" => route("api.v1.notes.show", $note->getRouteKey())
                    ]
                ]
            ]);

    }

    /** @test */
    public function test_can_not_fetch_note_data_to_edit_without_content_type_header(){

        $note = Note::create([
            "title" => "Note original title",
            "content" => "Note original content"
        ]);

        $response = $this->getJson( route("api.v1.notes.edit", $note->getRouteKey()) );

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

    /** @test */
    public function test_can_update_note()
    {
        $note = Note::create([
            "title" => "Note original title",
            "content" => "Note original content"
        ]);

        $data = [
            "data" => [
                "type" => "notes",
                "id" => (string) $note->getRouteKey(),
                "attributes" => [
                    "title" => "Note edited title"
                ]
            ]
        ];

        $response = $this->patchJson( route("api.v1.notes.update", $note->getRouteKey()), $data,[
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data" => [
                    "type" => "notes",
                    "id" => (string) $note->getRouteKey(),
                    "attributes" => [
                        "title" => "Note edited title",
                        "content" => "Note original content",
                        "created_at" => $note->created_at
                    ],
                    "links" => [
                        "self" => route("api.v1.notes.show", $note->getRouteKey())
                    ]
                ]
            ]);
    }

    /** @test */
    public function test_can_not_update_note_without_content_type_header()
    {
        $note = Note::create([
            "title" => "Note original title",
            "content" => "Note original content"
        ]);

        $data = [
            "data" => [
                "type" => "notes",
                "id" => (string) $note->getRouteKey(),
                "attributes" => [
                    "title" => "Note edited title"
                ]
            ]
        ];

        $response = $this->patchJson( route("api.v1.notes.update", $note->getRouteKey()), $data );

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
