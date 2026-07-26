-- Seed gradient color themes for /themer/index
-- Safe to re-run: skips codes that already exist.
-- Adjust column list if your themelist schema differs (DESCRIBE themelist).

INSERT INTO themelist (themecode)
SELECT 'STARBUCKS' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM themelist WHERE themecode = 'STARBUCKS');

INSERT INTO themelist (themecode)
SELECT 'XTWITTER' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM themelist WHERE themecode = 'XTWITTER');

INSERT INTO themelist (themecode)
SELECT 'INSTAGRAM' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM themelist WHERE themecode = 'INSTAGRAM');

INSERT INTO themelist (themecode)
SELECT 'CODER' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM themelist WHERE themecode = 'CODER');
