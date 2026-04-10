<?php

namespace tests\Services\Books\OpenLibrarySerializers;

use App\Services\Books\OpenLibrarySerializers\AuthorSerializer;
use PHPUnit\Framework\TestCase;

class AuthorSerializerTest extends TestCase
{
    public function testJsonDeserialization()
    {
        $json = '{"type": {"key": "/type/author"}, "source_records": ["bwb:9781529083491", "amazon:1443466107", "amazon:2743623799", "amazon:9124131393", "amazon:1524712175", "amazon:8580577071", "promise:bwb_daily_pallets_2022-05-16", "promise:bwb_daily_pallets_2023-01-24:W8-BQX-871"], "name": "Emily St. John Mandel", "remote_ids": {"wikidata": "Q3052385", "viaf": "26544203", "goodreads": "2786093", "isni": "0000000040565074", "imdb": "nm10808365", "lc_naf": "n2008082532", "librarything": "mandelemilystjohn", "opac_sbn": "MODV657046"}, "alternate_names": ["Emily St John Mandel", "Emily St. john mandel", "St. John Mandel  Emi", "St. John Mandel Emily", "St John Mandel Emily"], "key": "/authors/OL6538530A", "birth_date": "1979", "personal_name": "Emily St. John Mandel", "latest_revision": 8, "revision": 8, "created": {"type": "/type/datetime", "value": "2009-01-02T11:40:14.942523"}, "last_modified": {"type": "/type/datetime", "value": "2026-01-04T19:57:49.256856"}}';

        $openLibrarySerializer = new AuthorSerializer();
        $author = $openLibrarySerializer->fromJsonApi($json);

        $this->assertSame("1979", $author->birthDate);
        $this->assertSame("Emily St. John Mandel", $author->name);
        $this->assertSame("2786093", $author->goodreadId);
    }
}
