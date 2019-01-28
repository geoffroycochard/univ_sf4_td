<?php
/**
 * Created by PhpStorm.
 * User: geoffroycochard
 * Date: 22/01/2019
 * Time: 10:59
 */

namespace App\EventListener;

use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UpdateListener
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // only act on some "Product" entity
        if (!$entity instanceof Ticket) {
            return;
        }


        /** @var Ticket $entity */
        dump($entity);
        dump($this->mailer);

        $tos = [];
        /** @var User $user */
        foreach ($entity->getUsers() as $user) {
            $tos[] = $user->getEmail();
        }

        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['me@me.fr'])
            ->setTo($tos)
            ->setBody(sprintf('New ticket ID %s', $entity->getId()))
        ;
        $ret = $this->mailer->send($message);
        dump($ret);
        die();
//        $mailer->
        // ... do something with the Product
    }
}