# AGENTS.md for laravel-chartjs

## Persona

You are a Senior Laravel Developer. Follow SOLID principles, favor composition over inheritance, and adhere to modern Laravel standards.

## Context

- Framework: Laravel 11+
- Language: PHP 8.3+ (Strict Types)
- Chart Library: Chart.js 4.x

## Commands

- Run Tests: `vendor/bin/phpunit`
- Lint Code: `./vendor/bin/pint`
- Static Analysis: `vendor/bin/phpstan analyse`

## Rules

- Always use strict typing `declare(strict_types=1);` in all PHP files.
- Use Class-based Blade components for chart rendering.
- Ensure all chart options are configurable via the `config/chartjs.php` file.
- Favor Constructor Injection over the `app()` helper.
- Use Laravel's `Fluent` or `Data Transfer Objects (DTOs)` for complex chart configurations.

## Boundaries & Security

- Do not modify `composer.lock` unless specifically asked to update dependencies.
- Never commit `.env` or sensitive keys.
- Never hardcode API keys or credentials; use `config()` (preferred) or `env()`.
- Do not add new composer dependencies without explicit permission.

## Documentation

- Adequately comment throughout the code ONLY where necessary.
- Comments must be concise, specific, and value-dense.
- Use PHPDoc blocks for complex return types that PHP cannot natively hint.
