<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Resources\SongResource;
use App\Http\Resources\AlbumResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SongResourceTest extends TestCase
{
    use RefreshDatabase;


    public function testCorrectDataIsReturnedInResponse()
    {
        $resource = (new SongResource($song = factory('App\Song')->create()))->jsonSerialize();
        $this->assertArraySubset([
            'title' => $song->title,
            'rating' => $song->rating
        ], $resource);
    }

    public function testSongHasAlbumRelationship()
    {
        $resource = (new SongResource($song = factory('App\Song')->create(["album_id" => factory('App\Album')->create(['id' => 1])])))->jsonSerialize();
        $this->assertInstanceOf(AlbumResource::class, $resource["album"]);
    }
}
