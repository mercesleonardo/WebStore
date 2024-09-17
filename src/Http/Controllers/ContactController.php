<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Core\Database\Connector;
use Core\Html\View;
use Core\Http\Enums\HttpMethod;
use Core\Http\RedirectResponse;
use Core\Http\Request;
use Core\Router\Attributes\Route;
use Core\Session\Session;
use Core\Validation\Validator;

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
    public function store(Request $request, Connector $db): RedirectResponse
    {
        $validator = new Validator([
            'name'    => ['required', 'min:3', 'max:100'],
            'email'   => ['required', 'email', 'max:100'],
            'source'  => ['required'],
            'message' => ['required', 'max:255'],
        ], $request->input());

        if ($validator->fails()) {
            $this->session
                ->withErrors($validator->getErrors())
                ->withInput($request->input());

            return redirect('/contact');
        }

        $id = $db
            ->query('INSERT INTO messages (name, email, source, message) VALUES (:name, :email, :source, :message)', $request->input())
            ->insert();

        $type = 'success';
        $message = 'Sua mensagem foi enviada com sucesso!';

        if (!$id) {
            $type = 'danger';
            $message = 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.';
        }

        $this->session->flash($type, $message);

        return redirect('/contact');
    }
}