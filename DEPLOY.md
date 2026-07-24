# Deployment Notes

Files and steps that must be set up on every new environment (they are NOT in git).

## 1. `.env` (required — app fatals without it)

Copy the template and fill in real values:

```bash
cp .env.example .env
```

Loaded by `common/config/main-local.php` via symfony/dotenv. Minimum required:

| Key | Notes |
|-----|-------|
| `DB_HOST` / `DB_PORT` | Defaults to `127.0.0.1:3306` if unset |
| `DB_USER` / `DB_PASS` | MySQL credentials |
| `DB_SCHEMA` | Database name (e.g. `web_universe`) |
| `DB_CHARSET` | `utf8` |
| `SYSTEM_TYPE`, `RELEASE`, `VERSION` | App identity/branding |

## 2. Composer dependencies

`vendor/` is not committed:

```bash
composer install --no-dev
```

## 3. Yii environment configs

Local config overrides live in `*/config/main-local.php` and `*/config/params-local.php`
(common, backend, console). These ARE committed here because secrets moved to `.env` —
but if you use the Yii `init` script (`php init --env=prod`) it will overwrite them from
`environments/prod/`. Check `environments/` templates match before running `init`.

## 4. Writable directories (web server user needs write access)

```bash
mkdir -p backend/runtime console/runtime assets
chmod -R 775 backend/runtime console/runtime assets
```

- `assets/` — Yii published assets (regenerated, gitignored)
- `backend/runtime/`, `console/runtime/` — logs, cache (gitignored)

## 5. Web server

- Document root: project root (`index.php` is the frontend entry; `backend/` is admin)
- `.htaccess` at root handles rewrites (Apache). For nginx/Herd, pretty URLs handled by server config.
- PHP 8.x (see `UPGRADE-PHP8.md`), MySQL — legacy 5.x SQL mode relaxed per-session in `common/config/main-local.php` (`NO_ENGINE_SUBSTITUTION`).

## 6. Database

- Import schema/dump into the `DB_SCHEMA` database.
- Stored procedures / triggers documented in `jaoski-notes/` txt files (local only, not in git) — apply the ones relevant to the release.

## Checklist

- [ ] `.env` created and filled
- [ ] `composer install --no-dev`
- [ ] `runtime/` + `assets/` dirs exist and writable
- [ ] Database imported, credentials match `.env`
- [ ] Web server rewrites working (`/admin/login` loads)
