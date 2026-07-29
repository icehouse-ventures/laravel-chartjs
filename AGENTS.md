# Contributor guidance for laravel-chartjs

## Project context

- PHP 8.2+ package for Laravel applications.
- The supported framework versions are Laravel 12 and 13.
- Chart.js 4 is the default and security-supported browser runtime.
- Chart.js 2 and 3 assets remain available for migration compatibility.
- Both standard Blade and Livewire rendering paths are supported.

## Validation commands

- Install PHP dependencies: `composer install`
- Run the complete PHP check: `composer check`
- Run tests only: `composer test`
- Check formatting: `composer lint`
- Run PHPStan: `composer analyse`
- Install JavaScript dependencies: `npm ci`
- Rebuild the Chart.js 4 distribution: `npm run build`
- Check dependency advisories: `composer audit` and `npm audit`

Run `composer check` after PHP, Blade, configuration, or test changes. Run
`npm run build` after JavaScript dependency or source changes and commit the
resulting `dist/chart.js` update.

## Implementation rules

- Preserve PHP 8.2 compatibility and use native types plus precise PHPDoc where
  PHP cannot express an array shape or generic type.
- Keep normal and Livewire asset delivery aligned through
  `chart-scripts.blade.php`.
- Treat Chart.js configuration arrays as data. Encode them with the shared,
  exception-throwing and HTML-safe JSON path in `Builder`.
- Treat string values passed to `optionsRaw()` as trusted, application-authored
  JavaScript. Never interpolate user input into them.
- Keep CDN dependencies pinned to a supported major version so applications do
  not receive an unexpected breaking browser dependency.
- Do not edit `dist/chart.js` by hand; rebuild it from
  `src/resources/js/chart.js`.
- Do not remove or overwrite the Chart.js 2 or 3 distribution files during a
  Chart.js 4 build.
- Add or update tests for behavior changes, especially Blade output, JSON
  encoding, publishable assets, and version-specific chart types.

## Dependency and compatibility changes

- Update `composer.lock` or `package-lock.json` when their manifests change.
- Do not disable Composer security-advisory blocking to make an unsupported
  framework lane install.
- Add compatibility lanes deliberately and test the lowest supported PHP and
  framework combination.
- Changes to the PHP floor, default Chart.js major, generated browser assets, or
  public builder behavior require explicit release notes and may require a major
  release.

## Documentation and security

- Use the “Chart.js” name in prose.
- Prefer concise comments that explain a non-obvious constraint.
- Never add secrets, credentials, `.env` files, or application-specific data.
- Document migration-only support separately from actively tested and
  security-supported versions.
