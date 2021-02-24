<?php


namespace App\Repository\AuthorRepository;


use App\Models\Subscribe;

class SubscriberRepository
{
  public  function subscriberStore($request)
  {

      $tags =Subscribe::create([
          'email' => $request->email,

      ]);
      return $tags;
  }
  public  function  getSubscriber()
  {
      $subscriber=Subscribe::latest()->get();
      return $subscriber;
  }
  public  function  getSubscriberId($id)
  {
      $subscriber=Subscribe::find($id);
      return $subscriber;

  }
  public  function subscriberDelete($id)
  {
      return $this->getSubscriberId($id)->delete();
  }
}
