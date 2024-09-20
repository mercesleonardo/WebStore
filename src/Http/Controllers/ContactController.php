<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Message;
use Core\Html\View;
use Core\Http\Enums\HttpMethod;
use Core\Http\RedirectResponse;
use Core\Http\Request;
use Core\Router\Attributes\Route;
use Core\Session\Session;
use Core\Validation\Validator;
use Exception;

class ContactController
{
    public function __construct(
        protected Session $session
    ) {}

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
                'success' => $this->session->getFlash('success'),
                'error'   => $this->session->getFlash('danger'),
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

            return redirect('/contact')
                ->with('success', 'Your message has been sent successfully!');
        } catch (Exception) {
            return redirect('/contact')
                ->back()
                ->withInput()
                ->with('danger', 'An error occurred while sending the message. Please try again!');
        }
    }
}
