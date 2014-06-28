<?php

namespace SayAndDo\ProfileBundle\Controller;

use Doctrine\ORM\EntityRepository;
use SayAndDo\ProfileBundle\Service\ProfileService;
use SayAndDo\TaskBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SayAndDo\ProfileBundle\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        /** @var EntityRepository $repo */
        $repo = $this->get('doctrine.orm.default_entity_manager')->getRepository('SayAndDoProfileBundle:Profile');

        return $this->render(
            'SayAndDoProfileBundle:Profile:index.html.twig',
            array(
                'profiles' => $repo->findBy(
                    [],
                    ['points' => 'DESC']
                )
            )
        );
    }

    /**
     * @ParamConverter("profile", class="SayAndDoProfileBundle:Profile")
     */
    public function detailsAction(Profile $profile)
    {
        /** @var ProfileService $profileService */
        $profileService = $this->get('sd_profile.service');

        return $this->render(
            'SayAndDoProfileBundle:Profile:details.html.twig',
            array(
                'profile'           => $profile,
                'profile_rating'    => $profileService->getRating($profile),
                'tasks_confirmed'   => $profileService->getTasksConfirmed($profile),
                'tasks_in_progress' => $profileService->getTasksInProgress($profile),
                'tasks_done'        => $profileService->getTasksDone($profile),
            )
        );
    }
}
