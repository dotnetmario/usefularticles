<?php

return [
    'news_api' => [
        'url' => 'http://newsapi.org/v2/',
        'key' => '37f07085f6b7497091be8ed430b9857d',
        'endpoints' => [
            'all' => 'everything', // search for  recent news and blog article published by over 50,000 different sources.
            'top' => 'top-headlines', // search for breaking news headlines for a country and category, or currently running on a single or multiple sources.
            'info' => 'sources' // search for information (including name, description, and category) about the most notable sources.
        ],
        'countries' => [ // possible countries to get results from
            'ae', 'ar', 'at', 'au', 'be', 'bg', 'br', 'ca', 'ch', 'cn', 'co', 'cu', 'cz', 'de', 'eg', 'fr', 'gb', 'gr', 'hk', 'hu', 'id', 'ie', 'il', 'in', 'it', 'jp', 'kr', 'lt', 'lv', 'ma', 'mx', 'my', 'ng', 'nl', 'no', 'nz', 'ph', 'pl', 'pt', 'ro', 'rs', 'ru', 'sa', 'se', 'sg', 'si', 'sk', 'th', 'tr', 'tw', 'ua', 'us', 've', 'za'
        ],
        'categories' => [ // possible categories
            'business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'
        ],
        'languages' => [ // possibke languages
            'ar', 'de', 'en', 'es', 'fr', 'he', 'it', 'nl', 'no', 'pt', 'ru', 'se', 'ud', 'zh'
        ],
        'sorting' => [ // possible sorting ways
            'publishedAt', // newer articles come first (default)
            'relevancy', // articles more closely related to the query come first.
            'popularity', // articles from popular sources and publishers come first.
        ]
    ],
];