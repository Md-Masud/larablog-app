<?php

namespace App\Http\Controllers;

use App\Repository\AuthorRepository\SubscriberRepository;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    private $subscriberRepository;
    public  function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository=$subscriberRepository;
    }
    public function  store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:subscribes'
        ]);
        try {
            $this->subscriberRepository->subscriberStore($request);
            $this->setSuccessMessage('Post Successfully Saved');
            return redirect()->route('home');
        }
        catch (Exception $e)
        {
            $this->setErrorMessage($e->getMessage());
        }


    }
}
