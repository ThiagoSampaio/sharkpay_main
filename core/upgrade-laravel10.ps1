$ErrorActionPreference = 'Stop'
$env:COMPOSER_MEMORY_LIMIT = '-1'

Set-Location $PSScriptRoot

$command = @(
    'update',
    'laravel/framework',
    'laravel/passport',
    'nunomaduro/collision',
    'spatie/laravel-ignition',
    'phpunit/phpunit',
    'monolog/monolog',
    '--with-all-dependencies',
    '--no-scripts',
    '--no-interaction'
)

& composer @command 2>&1 | Tee-Object -FilePath 'composer10-upgrade.log'
exit $LASTEXITCODE