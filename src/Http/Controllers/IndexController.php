<?php

namespace Ahmedwassef\LaravelEmailSentry\Http\Controllers;
use Illuminate\Routing\Controller;
use MailSentry;
class IndexController extends Controller
{

    public function index()
    {
        // Paginate records
        $emails = MailSentry::getEmailsPaginated();

        return view('EmailSentry::index',['emails'=>$emails]);

    }

    public function show($id)
    {
        // Paginate records
        $email = MailSentry::find($id);

        return view('EmailSentry::details',['email'=>$email]);

    }

}
