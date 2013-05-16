<?php

/*
* This file is part of Zeega.
*
* (c) Zeega <info@zeega.org>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Zeega\DataBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use Zeega\CoreBundle\Helpers\ResponseHelper;
use Zeega\DataBundle\Entity\User;

/**
 * Updates a task status
 *
 */
class UpdateUserRoleCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */       
    protected function configure()
    {
        $this->setName('zeega:users:update_roles')
             ->setDescription('Upgrade user roles')
             ->setHelp("Help");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $users = $em->getRepository('ZeegaDataBundle:User')->findAll();
        $counter = 0;
        foreach($users as $user) {
            $roles = $user->getRoles();
            
            $key = array_search("ROLE_CUTTINGEDGE",$roles);
            if($key!==false){
                unset($roles[$key]);
            }

            if( !in_array("ROLE_EDITOR_V1.1",$roles) ) {
                array_push($roles, "ROLE_EDITOR_V1.1");
            }

            var_dump($user->getId());

            $user->setRoles($roles);
            $em->persist($user);

            $counter = $counter + 1;

            if ($counter % 1000 == 0) {
                $counter = 0;
                $em->flush();
            }
        }
    }
}
