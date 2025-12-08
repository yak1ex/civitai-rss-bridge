<?php

declare(strict_types=1);

class CivitaiBridge extends BridgeAbstract
{
    const NAME = 'Civitai (civitai.com)';
    const CACHE_TIMEOUT = 0; # for testing purposes
    const DESCRIPTION = 'Fetches the newest models from Civitai';
    const MAINTAINER = 'yak1ex';

    public function collectData()
    {
        $url = 'https://civitai.com/api/v1/models?limit=3&sort=Newest';
        $header = array('Content-Type: application/json');
        $raw = getContents($url, $header);
        $json = json_decode($raw, true);
        foreach ($json['items'] as $item) {
            $this->items[] = [
                'title' => $item['name'],
                'uri' => 'https://civitai.com/models/' . $item['id'],
            ];
        }
    }
}
