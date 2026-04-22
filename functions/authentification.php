<?php
function is_connected(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['connected']);
}

/* tutto questo è per vedere se la persona è ancora connessa 
PHP _ SESSION _ DISABLED si les sessions sont désactivées.
PHP _ SESSION _ NONE si les sessions sont activées, mais qu'aucune n'existe.
PHP _ SESSION _ ACTIVE si les sessions sont activées, et qu'une existe. */