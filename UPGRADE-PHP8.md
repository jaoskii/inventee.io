# PHP 8 upgrade notes (universe-aims)

## Target runtime

- **PHP 8.3** (recommended; Herd `php83`)
- **Yii 2.0.55** (`yiisoft/yii2: ~2.0.55`)
- Composer 2 + [asset-packagist.org](https://asset-packagist.org) for `bower-asset/*`

Defer **PHP 8.4** until remaining deprecations in legacy modules are cleaned.

## Dependency changes

| Old | New |
|-----|-----|
| `yiisoft/yii2` 2.0.42.1 | `~2.0.55` |
| `yiisoft/yii2-swiftmailer` + SwiftMailer 5 | `yiisoft/yii2-symfonymailer` ^4 |
| `symfony/dotenv` ^3.4 | ^5.4 / ^6 / ^7 |
| `yiisoft/yii2-codeception` | removed |

Mailer config lives in `backend/config/main.php` (`yii\symfonymailer\Mailer` + SMTPS transport array).

## Boot / PHP 8 fixes applied

- Root `index.php` defines `YII_DEBUG` / `YII_ENV` (required by `backend/config/main-local.php`)
- `Webproc::sanitize` guards removed `get_magic_quotes_gpc()`
- Tax withhold reports: `split()` → `explode()`
- `backendfunctions::searchForCode` — optional param before required fixed
- NuSOAP `sendHTTPS` — `$cookies = null` default

## NuSOAP / services module

Bundled NuSOAP still uses PHP 4-style constructors. On PHP 8+, `backend/modules/services/views/default/index.php` returns **HTTP 503** and does not load NuSOAP.

Options later: full NuSOAP PHP 8 port, or rewrite with PHP `SoapServer` / `SoapClient`.

## Local setup (Mac / Herd)

1. Use PHP 8.3: `php83` / Herd site PHP version 8.3
2. Document root = repo root (`index.php`)
3. `composer install` (lock already regenerated)
4. Copy `.env-backup` → `.env` and set `DB_*` + `RELEASE`
5. MySQL with `pdo_mysql`; also `mbstring`, `openssl`, `gd` recommended

## Smoke checklist

- [ ] `php83 -r` / Herd boots app (Yii 2.0.55, symfonymailer)
- [ ] Login + main AdminLTE shell with real DB
- [ ] One lookup modal, one report (non-SOAP)
- [ ] Confirm `/services` returns 503 isolation message on PHP 8

## Out of scope

- Yii 3 migration
- Full module-by-module QA of all backends
- NuSOAP rewrite
