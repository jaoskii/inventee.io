<?php
// Lightweight healthcheck endpoint — no DB, no Yii bootstrap.
// Railway probes this to confirm the container/Apache is alive.
http_response_code(200);
header('Content-Type: text/plain');
echo 'OK';
