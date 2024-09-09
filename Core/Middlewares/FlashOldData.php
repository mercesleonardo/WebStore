<?php

namespace Core\Middlewares;

class FlashOldData
{
    private array $dontFlash = ['password'];

    public function handle(): void
    {
        $data = $_POST;

        if (empty($data)) {
            return;
        }

        unset($_SESSION['old']);

        foreach ($data as $key => $value) {
            if (!in_array($key, $this->dontFlash)) {
                $_SESSION['old'][$key] = $value;
            }
        }
    }
}