<?php

namespace App\GraphQL\Mutations;

use App\Models\Link;
use Illuminate\Support\Str;

class LinkMutator {
    public function create($rootValue, array $args) {
        $url = $args['url'];

        $existingLink = Link::where('url', $url)->first();

        if($existingLink) {
            return $existingLink;
        }

        $shortenedUrl = $this->generateUniqueShortLink($url);

        $link = Link::create([
            'url' => $url,
            'shortened_url' => $shortenedUrl,
            'clicks' => 0,
        ]);

        return $link;
    }

    protected function generateUniqueShortLink($url = ''): string
    {
        do {
            $shortenedUrl = $this->hashUrl($url);
        } while (Link::where('shortened_url', $shortenedUrl)->exists());

        return $shortenedUrl;
    }

    private function hashUrl($url)
    {
        $primaryHash = hash('crc32b', $url);
        $combinedString = $primaryHash . Str::random(6);

        return hash('crc32b', $combinedString);
    }
}
