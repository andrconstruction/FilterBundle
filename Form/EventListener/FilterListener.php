<?php declare(strict_types = 1);
/*
 * This file is part of the Bukashk0zzzFilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Form\EventListener;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class FilterListener
 */
class FilterListener implements EventSubscriberInterface
{
    /**
     * @var Filter
     */
    protected $filterService;

    /**
     * FilterListener constructor.
     *
     * @param Filter $filterService
     */
    public function __construct(Filter $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];
    }

    /**
     * @param FormEvent $event
     *
     * @return void
     */
    public function onPostSubmit(FormEvent $event): void
    {
        $clientData = $event->getData();

        if (!\is_object($clientData)) {
            return;
        }

        $this->filterService->filterEntity($clientData);
    }
}
