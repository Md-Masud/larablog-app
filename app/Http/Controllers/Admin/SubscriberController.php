<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\AuthorRepository\SubscriberRepository;
use Illuminate\Http\Request;


class SubscriberController extends Controller
{
    private $subscriberRepository;
    public  function  __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository=$subscriberRepository;
    }
    public  function  index()
    {
        $subscribers=$this->subscriberRepository->getSubscriber();
        return view('admin.subscriber',compact('subscribers'));
    }
    public function destroy($id)
    {
        try {
            $this->subscriberRepository->subscriberDelete($id);
            $this->setSuccessMessage('subscriber delete successful');
           return redirect()->route('admin.subscriber.index');
        }
        catch (Exception $e)
        {
            $this->setErrorMessage($e->getMessage());
        }
    }
}
