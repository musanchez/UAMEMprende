<?php
namespace App\Observers;


use App\Observers;

class ProductoSubject implements Subject
{
    protected $observers = [];

    // Método para agregar un observador
    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    // Método para eliminar un observador
    public function detach(Observer $observer)
    {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    // Método para notificar a todos los observadores
    public function notify($data)
    {
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }
}
