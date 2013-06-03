<?php

namespace Bc\Bundle\UserBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SetNameFieldSubscriber implements EventSubscriberInterface
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(
            FormEvents::PRE_BIND => 'preBind',
            FormEvents::POST_BIND => 'postBind'
        );
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();

        $this->firstName = $data['name']['firstName'];
        $this->lastName = $data['name']['lastName'];
    }

    public function postBind(FormEvent $event)
    {
        $data = $event->getData();
        $data->setFirstName($this->firstName);
        $data->setLastName($this->lastName);
    }
}