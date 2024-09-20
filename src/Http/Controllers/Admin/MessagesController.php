<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Core\Router\Attributes\Route;

class MessagesController
{
    #[Route('/admin/messages', middlewares: ['auth', 'admin'])]
    public function __invoke(): string
    {
        $messages = Message::all();

        $title   = 'My Messages';
        $heading = $title;

        return view('admin/messages', [
            'title'    => $title,
            'heading'  => $heading,
            'messages' => $messages,
        ]);
    }
}
