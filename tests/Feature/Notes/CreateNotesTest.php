<?php

namespace Tests\Feature\Notes;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_create_a_note()
    {        
        $note = [
            "data" => [
                "type" => "notes",
                "attributes" => [
                    "title" => "Note title",
                    "content" => "Note Content",
                ]
            ]
        ];

        $response = $this->postJson( route("api.v1.notes.store"), $note, [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(201)
            ->assertHeader("Location", route( "api.v1.notes.show", $response["data"]["id"] ))
            ->assertExactJson([
                "data" => [
                    "type" => "notes",
                    "id" => $response["data"]["id"],
                    "attributes" => [
                        "title" => $note["data"]["attributes"]["title"],
                        "content" => $note["data"]["attributes"]["content"],
                        "created_at" => $response["data"]["attributes"]["created_at"]
                    ],
                    "links" => [
                        "self" => route( "api.v1.notes.show", $response["data"]["id"] )
                    ]
                ]
            ]);
    }

    /** @test */
    public function test_can_not_create_a_note_with_empty_title()
    {        
        $note = [
            "data" => [
                "type" => "notes",
                "attributes" => [
                    "title" => "",
                    "content" => "Note content",
                ]
            ]
        ];

        $response = $this->postJson( route("api.v1.notes.store"), $note, [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(403)
            ->assertExactJson([
                "errors" => [
                    "status" => "403",
                    "title" => "Forbidden",
                    "detail" => "You must provide a title",
                    "source" => [
                        "pointer" => "data/attributes/title"
                    ]
                ]
            ]);
    }

    /** @test */
    public function test_can_not_create_a_note_with_empty_content()
    {        
        $note = [
            "data" => [
                "type" => "notes",
                "attributes" => [
                    "title" => "Note title",
                    "content" => "",
                ]
            ]
        ];

        $response = $this->postJson( route("api.v1.notes.store"), $note, [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(403)
            ->assertExactJson([
                "errors" => [
                    "status" => "403",
                    "title" => "Forbidden",
                    "detail" => "You must provide content",
                    "source" => [
                        "pointer" => "data/attributes/content"
                    ]
                ]
            ]);
    }

    /** @test */
    public function test_can_not_create_a_note_whithout_content_type_header()
    {        
        $note = [
            "data" => [
                "type" => "notes",
                "attributes" => [
                    "title" => "Note title",
                    "content" => "Note Content",
                ]
            ]
        ];

        $response = $this->postJson( route("api.v1.notes.store"), $note );

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

    public function test_can_not_create_a_note_with_a_invalid_request_format(){

        $note = [
            "title" => "Note title",
            "content" => "Note content"
        ];

        $response = $this->postJson( route("api.v1.notes.store"), $note, [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(403)
            ->assertExactJson([
                "errors" => [
                    "status" => "403",
                    "title" => "Forbidden",
                    "detail" => "Request format, invalid. You must follow JsonAPI Specification to create a resource.",
                    "source" => [
                        "pointer" => "Request format"
                    ]
                ]
            ]);

    }

}
