<?php

namespace App\Observers;


interface Subject
{
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify($data);
}
