<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Helpers\Toast;
use App\Models\Message;
use Core\Html\View;
use Core\Http\Enums\HttpMethod;
use Core\Http\RedirectResponse;
use Core\Http\Request;
use Core\Router\Attributes\Route;
use Core\Validation\Validator;
use Exception;

class ContactController
{
    #[Route('/contact')]
    public function index(): string
    {
        $sources = [
            'google', 'facebook', 'twitter', 'instagram',
        ];

        return (new View())
            ->render('contact', [
                'title'   => 'Contact Us',
                'heading' => 'Contact Us',
                'sources' => $sources,
            ]);
    }

    #[Route('/contact', HttpMethod::Post)]
    public function store(Request $request): RedirectResponse
    {
        (new Validator([
            'name'    => ['required', 'min:3', 'max:100'],
            'email'   => ['required', 'email', 'max:100'],
            'source'  => ['required'],
            'message' => ['required', 'max:255'],
        ], $request->input()))->validate();

        try {
            Message::create($request->input());

            Toast::success('Your message has been sent successfully!');

            return redirect('/contact');
        } catch (Exception) {
            Toast::error('An error occurred while sending the message. Please try again!');

            return redirect('/contact')
                ->back()
                ->withInput();
        }
    }
}
