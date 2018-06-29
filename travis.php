<?php

$phpVersions = [
    '5.4',
    '5.5',
    '5.6',
    '7.0',
    '7.1',
    '7.2',
];
$laravelVersions = [
    '5.0',
    '5.1',
    '5.2',
    '5.3',
    '5.4',
    '5.5',
    '5.6',
    'dev-master' => '5.7',
];
$carbonVersions = [
    'dev-master',
    'dev-version-2.0',
];

$laravelPackages = json_decode(file_get_contents('https://packagist.org/p/laravel/framework.json'), true)['packages']['laravel/framework'];
$readme = file_get_contents(__DIR__.'/README.md');
$tableCarbon = [[], []];

$matrix = '';
$count = 0;

foreach ($phpVersions as $phpVersion) {
    foreach ($laravelVersions as $laravelKey => $laravelVersion) {
        $key = $laravelKey;
        $stable = is_int($key);
        $laravel = $laravelVersion;
        if ($stable) {
            $key = "v$laravel";
        } else {
            $laravel = "$key as $laravel";
        }
        $packageVersions = array_filter(array_keys($laravelPackages), function ($version) use ($key) {
            return strpos($version, $key) === 0;
        });
        usort($packageVersions, 'version_compare');
        $version = end($packageVersions);
        if ($stable) {
            $laravel = ltrim($version, 'v');
        }
        $package = $laravelPackages[$version];
        $php = $package['require']['php'];

        if (version_compare($phpVersion.'.999', ltrim($php, '^>='), '<')) {
            continue;
        }

        foreach ($carbonVersions as $index => $carbonVersion) {
            if ($carbonVersion === 'dev-version-2.0' && (version_compare($phpVersion, '7.1', '<') || version_compare($laravelVersion, '5.6', '<'))) {
                continue;
            }

            if (!isset($tableCarbon[$index][$phpVersion])) {
                $tableCarbon[$index][$phpVersion] = [];
            }
            $tableCarbon[$index][$phpVersion][] = $laravelVersion;

            $carbon = "$carbonVersion as ".(version_compare($laravelVersion, '5.7', '<') ? '1.25.0' : '1.27.0');
            $matrix .= "
    - php: $phpVersion
      env:
        - CARBON_VERSION='\"$carbon\"'
        - LARAVEL_VERSION='\"$laravel\"'";
            if (version_compare($phpVersion, '7.2', '>=') && version_compare($laravelVersion, '5.1', '<')) {
                $matrix .= "
        - COMPOSER_PLATFORM_REQS='--ignore-platform-reqs'";
            }
            $count++;
        }
    }
}

$travis = <<<EOF
language: php

cache:
  apt: true
  directories:
    - \$HOME/.composer/cache

matrix:
  include:$matrix

before_script:
  - travis_retry composer self-update
  - travis_retry php setVersions.php \$CARBON_VERSION \$LARAVEL_VERSION
  - travis_retry composer update -o --no-interaction --prefer-stable \$COMPOSER_PLATFORM_REQS

script:
  - vendor/bin/phpunit

EOF;

if (!file_put_contents(__DIR__.'/.travis.yml', $travis)) {
    echo "Failing writing in .travis.yml.\n";
    exit(1);
}

echo "$count environments generated in .travis.yml.\n";

$index = -1;
$readme = preg_replace_callback('/(\|PHP\|Laravel\|\n\|---\|-------\|\n)([\s\S]+)\n{2}/U', function ($match) use (&$index, $tableCarbon) {
    $index++;
    $table = '';
    foreach ($tableCarbon[$index] as $php => $laravel) {
        $isRange = count($laravel) > 2 && array_reduce($laravel, function ($previous, $next) {
            if ($previous === null || (int) round(($next - $previous) * 10) === 1) {
                return $next;
            }

            return false;
        }, null);
        $table .= "|$php|".($isRange ? $laravel[0].' ➡ '.end($laravel) : implode(', ', $laravel))."|\n";
    }

    return $match[1]."$table\n";
}, $readme);

if (!file_put_contents(__DIR__.'/README.md', $readme)) {
    echo "README.md could not be updated.\n";
    exit(1);
}

echo "README.md update.\n",
exit(0);

