<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use Core\Database\Connector;
use Core\Router\Attributes\Route;

class MessagesController
{
    #[Route('/admin/messages', middlewares: ['auth', 'admin'])]
    public function __invoke(Connector $db): string
    {
        $messages = $db
            ->query('SELECT * FROM messages')
            ->get();

        $title   = 'My Messages';
        $heading = $title;

        return view('admin/messages', [
            'title'    => $title,
            'heading'  => $heading,
            'messages' => $messages,
        ]);
    }
}
