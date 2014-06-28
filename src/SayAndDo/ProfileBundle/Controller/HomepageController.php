<?php

namespace SayAndDo\ProfileBundle\Controller;

use Doctrine\ORM\EntityRepository;
use SayAndDo\ProfileBundle\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function homepageAction()
    {
        /** @var ProfileService $profileService */
        $profileService = $this->get('sd_profile.service');

        /** @var EntityRepository $repo */
        $repo     = $this->get('doctrine.orm.default_entity_manager')->getRepository('SayAndDoProfileBundle:Profile');
        $profiles = $repo->findBy([], ['points' => 'DESC'], 5);
        $profiles = array_map(
            function ($profile) use ($profileService) {
                return [
                    'profile'           => $profile,
                    'tasks_confirmed'   => $profileService->getTasksConfirmed($profile),
                    'tasks_in_progress' => $profileService->getTasksInProgress($profile),
                    'tasks_done'        => $profileService->getTasksDone($profile),
                ];
            },
            $profiles
        );
        return $this->render(
            'SayAndDoProfileBundle:Homepage:homepage.html.twig',
            ['profiles' => $profiles]
        );
    }
}
