<?php
class Session{
    static public function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE)
        {
            return;
        }
        if (headers_sent()==1)
        {
            throw new SessionException("Impossible de modifier les entêtes HTTP");
        }
        if (session_status() == PHP_SESSION_DISABLED)
        {
            throw new SessionException("L'état de la session est incompatible ou incohérent");
        }

        session_start();
    }
}
