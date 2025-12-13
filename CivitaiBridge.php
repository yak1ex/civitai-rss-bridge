<?php

declare(strict_types=1);

class CivitaiBridge extends BridgeAbstract
{
    const NAME = 'Civitai (civitai.com)';
    const URI = 'https://civitai.com/';
    const CACHE_TIMEOUT = 0; # for testing purposes
    const DESCRIPTION = 'Fetches the newest models from Civitai';
    const MAINTAINER = 'yak1ex';
    const PARAMETERS = [
        '' => [
            'limit' => [
                'name' => 'Number of items to return',
                'type' => 'number',
                'defaultValue' => 20,
                'title' => 'Max 100',
            ],
            'query' => [
                'name' => 'Search query',
                'type' => 'text',
                'defaultValue' => '',
                'title' => 'Leave empty to get the newest models',
            ],
            'tag' => [
                'name' => 'Tag',
                'type' => 'text',
                'defaultValue' => '',
            ],
            'username' => [
                'name' => 'Username',
                'type' => 'text',
                'defaultValue' => '',
            ],
            'types_checkpoint' => [
                'name' => 'Types: Checkpoint',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_textualinversion' => [
                'name' => 'Types: TextualInversion',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_hypernetwork' => [
                'name' => 'Types: Hypernetwork',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_aestheticgradient' => [
                'name' => 'Types: AestheticGradient',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_lora' => [
                'name' => 'Types: LORA',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_locon' => [
                'name' => 'Types: LoCon',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_dora' => [
                'name' => 'Types: DoRA',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_controlnet' => [
                'name' => 'Types: Controlnet',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_upscaler' => [
                'name' => 'Types: Upscaler',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_motionmodule' => [
                'name' => 'Types: MotionModule',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_vae' => [
                'name' => 'Types: VAE',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_poses' => [
                'name' => 'Types: Poses',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_wildcards' => [
                'name' => 'Types: Wildcards',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_workflows' => [
                'name' => 'Types: Workflows',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_detection' => [
                'name' => 'Types: Detection',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'types_other' => [
                'name' => 'Types: Other',
                'type' => 'checkbox',
                'title' => 'Leave all unchecked to get all types',
            ],
            'sort' => [
                'name' => 'Sort by',
                'type' => 'list',
                'values' => [
                    'Highest Rated' => 'Highest Rated',
                    'Most Downloaded' => 'Most Downloaded',
                    'Newest' => 'Newest',
                ],
                'defaultValue' => 'Newest',
            ],
            'period' => [
                'name' => 'Period',
                'type' => 'list',
                'values' => [
                    'All Time' => 'AllTime',
                    'This Year' => 'Year',
                    'This Month' => 'Month',
                    'This Week' => 'Week',
                    'Today' => 'Day',
                ],
                'defaultValue' => 'All Time',
            ],
            'nsfw' => [
                'name' => 'Include NSFW content',
                'type' => 'checkbox',
                'title' => 'If unchecked, NSFW content will be filtered out',
                'defaultValue' => 'checked',
            ],
            'baseModels' => [
                'name' => 'Base Models',
                'type' => 'text',
                'title' => 'Comma-separated list of base models to filter by (e.g., "SD 1.5,Illustrious"). Please see https://github.com/yak1ex/civitai-rss-bridge/ for available values',
            ],
            'allowNoCredit' => [
                'name' => 'Allow No-Credit Models',
                'type' => 'checkbox',
                'title' => 'If checked, models that do not require credit will be included',
            ],
            'allowDerivatiives' => [
                'name' => 'Allow Derivative Models',
                'type' => 'checkbox',
                'title' => 'If checked, derivative models will be included',
            ],
            'allowDifferentLicenses' => [
                'name' => 'Allow Different License Models',
                'type' => 'checkbox',
                'title' => 'If checked, models with different licenses will be included',
            ],
            'allowCommercialUse' => [
                'name' => 'Allow Commercial Use Models',
                'type' => 'list',
                'values' => [
                    '' => '',
                    'None' => 'None',
                    'Image' => 'Image',
                    'Rent' => 'Rent',
                    'Sell' => 'Sell',
                ],
                'title' => 'If left empty, all models will be included. If set, models that allow the specified commercial use will be included',
            ],
            'supportsGeneration' => [
                'name' => 'Supports Generation',
                'type' => 'checkbox',
                'title' => 'If checked, only models that support generation will be included',
            ],
            'token' => [
                'name' => 'API Token (BE CAUTIOUS)',
                'type' => 'text',
                'title' => 'Optional API token for Civitai. Required for below parameters. NOTE THAT PROVIDING YOUR API TOKEN HERE MAY POSE A SECURITY RISK. THIS TOKEN IS PASSED AS A URL PARAMETER. ONLY USE THIS IF YOU TRUST THE HOSTING ENVIRONMENT COMPLETELY.',
            ],
            'favorites' => [
                'name' => 'Only Favorites (API Token required)',
                'type' => 'checkbox',
                'title' => 'If checked, only models favorited by the user associated with the API token will be included. Requires API token.',
            ],
            'hidden' => [
                'name' => 'Include Hidden Models (API Token required)',
                'type' => 'checkbox',
                'title' => 'If checked, hidden models will be included. Requires API token.',
            ],
        ],
    ];

    public function collectData()
    {
        $baseUrl = 'https://civitai.com/api/v1/models';
        $url = $this->buildUrl($baseUrl);
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

    private function buildUrl($baseUrl)
    {
        $params = [];
        $types = [];
        $typeMap = [
            'types_checkpoint' => 'Checkpoint',
            'types_textualinversion' => 'TextualInversion',
            'types_hypernetwork' => 'Hypernetwork',
            'types_aestheticgradient' => 'AestheticGradient',
            'types_lora' => 'LORA',
            'types_locon' => 'LoCon',
            'types_dora' => 'DoRA',
            'types_controlnet' => 'Controlnet',
            'types_upscaler' => 'Upscaler',
            'types_motionmodule' => 'MotionModule',
            'types_vae' => 'VAE',
            'types_poses' => 'Poses',
            'types_wildcards' => 'Wildcards',
            'types_workflows' => 'Workflows',
            'types_detection' => 'Detection',
            'types_other' => 'Other',
        ];
        $stringParams = ['query', 'tag', 'username', 'sort', 'period', 'allowCommercialUse', 'token'];
        $boolParams = [
            'allowNoCredit',
            'allowDerivatiives',
            'allowDifferentLicenses',
            'supportsGeneration',
            'favorites',
            'hidden',
        ];

        foreach ($stringParams as $paramName) {
            $value = $this->getInput($paramName);
            if ($value !== null && $value !== '') {
                $params[$paramName] = $value;
            }
        }

        foreach ($boolParams as $inputName) {
            $value = $this->getInput($inputName);
            if ($value !== null && $value !== false) {
                $paramName = $inputName === 'allowDerivatiives' ? 'allowDerivatives' : $inputName;
                $params[$paramName] = 'true';
            }
        }

        $limit = $this->getInput('limit');
        if ($limit !== null && $limit !== '') {
            $params['limit'] = min((int) $limit, 100);
        }

        foreach ($typeMap as $inputKey => $typeName) {
            $value = $this->getInput($inputKey);
            if ($value !== null && $value !== false) {
                $types[] = $typeName;
            }
        }

        if (!empty($types)) {
            $params['types'] = $types;
        }

        $nsfw = $this->getInput('nsfw');
        $params['nsfw'] = $nsfw !== null && $nsfw !== false ? 'true' : 'false';

        $baseModels = $this->getInput('baseModels');
        if ($baseModels !== null && $baseModels !== '') {
            $baseModelArray = array_filter(array_map('trim', explode(',', $baseModels)));
            if (!empty($baseModelArray)) {
                $params['baseModels'] = $baseModelArray;
            }
        }

        $queryParts = [];
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $queryParts[] = urlencode($key) . '=' . urlencode((string) $item);
                }
                continue;
            }

            if ($value === null || $value === '') {
                continue;
            }

            $queryParts[] = urlencode($key) . '=' . urlencode(is_bool($value) ? ($value ? 'true' : 'false') : (string) $value);
        }

        $url = $baseUrl;
        if ($queryParts) {
            $url .= '?' . implode('&', $queryParts);
        }
        return $url;
    }
}
