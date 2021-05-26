<?php

namespace Tests\Feature\Notes;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_can_fetch_single_note()
    {
        $note = Note::factory()->create();
        
        $response = $this->getJson( route('api.v1.notes.show', $note->getRouteKey()), [
            "Content-Type" => "application/vnd.api+json"
        ]);

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
                    "self" => route( "api.v1.notes.show", $note->getRouteKey() )
                ]
            ]
        ]);

    }

    /** @test */
    public function test_can_not_fetch_single_article_without_content_type_header(){

        $note = Note::factory()->create();
        
        $response = $this->getJson( route('api.v1.notes.show', $note->getRouteKey()) );

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
    public function test_can_not_found_note(){

        $noteId = 1;

        $response = $this->getJson( route('api.v1.notes.show', $noteId), [
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

    /** @test */
    public function test_can_fetch_all_notes(){

        $notes = Note::factory()->times(3)->create();

        $response = $this->getJson( route('api.v1.notes.index'), [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data" => [
                    [
                        "type" => "notes",
                        "id" => (string) $notes[0]->getRouteKey(),
                        "attributes" => [
                            "title" => $notes[0]->title,
                            "content" => $notes[0]->content,
                            "created_at" => $notes[0]->created_at
                        ],
                        "links" => [
                            "self" => route( "api.v1.notes.show", $notes[0]->getRouteKey() )
                        ]
                    ],
                    [
                        "type" => "notes",
                        "id" => (string) $notes[1]->getRouteKey(),
                        "attributes" => [
                            "title" => $notes[1]->title,
                            "content" => $notes[1]->content,
                            "created_at" => $notes[1]->created_at
                        ],
                        "links" => [
                            "self" => route( "api.v1.notes.show", $notes[1]->getRouteKey() )
                        ]
                    ],
                    [
                        "type" => "notes",
                        "id" => (string) $notes[2]->getRouteKey(),
                        "attributes" => [
                            "title" => $notes[2]->title,
                            "content" => $notes[2]->content,
                            "created_at" => $notes[2]->created_at
                        ],
                        "links" => [
                            "self" => route( "api.v1.notes.show", $notes[2]->getRouteKey() )
                        ]
                    ],
                ],
                "links" => [
                    "self" => route("api.v1.notes.index")
                ]
        ]);

    }

    /** @test */
    public function test_fetch_empty_notes_array(){

        $response = $this->getJson( route("api.v1.notes.index"), [
            "Content-Type" => "application/vnd.api+json"
        ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data" => [],
                "links" => [
                    "self" => route("api.v1.notes.index")
                ]
            ]);

    }

    /** @test */
    public function test_can_not_fetch_all_articles_without_content_type_header(){
        
        $response = $this->getJson( route('api.v1.notes.index') );

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
