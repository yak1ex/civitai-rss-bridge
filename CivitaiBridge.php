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
            $latestVersionIndex = null;
            $latestVersionTime = null;

            foreach ($item['modelVersions'] as $index => $version) {
                $candidateDate = $version['publishedAt'] ?? $version['createdAt'] ?? null;
                if ($candidateDate === null) {
                    continue;
                }

                $candidateTimestamp = strtotime($candidateDate);
                if ($candidateTimestamp === false) {
                    continue;
                }

                if ($latestVersionTime === null || $candidateTimestamp > $latestVersionTime) {
                    $latestVersionIndex = $index;
                    $latestVersionTime = $candidateTimestamp;
                }
            }

            $latestVersion = $latestVersionIndex !== null ? $item['modelVersions'][$latestVersionIndex] : null;

            $enclosures = [];
            $prependImages = '<style>.outer-box { width: 100%; height: auto; overflow-x: auto; overflow-y: hidden; white-space: nowrap;   } .inner-box { display: flex; flex-direction: row; gap: 10px; width: fit-content} .inner-box img { max-width: 200px; height: auto; flex-shrink: 0; }</style><div class="outer-box"><div class="inner-box">';
            if ($latestVersion && isset($latestVersion['images'])) {
                foreach ($latestVersion['images'] as $image) {
                    if (isset($image['url'])) {
                        $enclosures[] = $image['url'];
                        $prependImages .= '<a href="' . htmlspecialchars($image['url']) . '"><img src="' . htmlspecialchars($image['url']) . '"></a>';
                    }
                }
            }
            $prependImages .= '</div></div>';
            $stats = '<p>📥 ' . ($item['stats']['downloadCount'] ?? 0)
                . ' 👍 ' . ($item['stats']['thumbsUpCount'] ?? 0)
                . ' / 📥 ' . ($latestVersion['stats']['downloadCount'] ?? 0)
                . ' 👍 ' . ($latestVersion['stats']['thumbsUpCount'] ?? 0) . '</p>';

            $this->items[] = [
                'title' => $item['name'],
                'uri' => 'https://civitai.com/models/' . $item['id'],
                'author' => $item['creator']['username'],
                'content' => $prependImages . $stats . $item['description'],
                'categories' => [$item['type'], $latestVersion['baseModel']] + $item['tags'],
                'timestamp' => $latestVersionTime,
                'enclosures' => $enclosures,
            ];
        }
    }
}
