<?php

/*
* This file is part of Zeega.
*
* (c) Zeega <info@zeega.org>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Zeega\PublishBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityRepository;
use Zeega\DataBundle\Entity\Project;
use Zeega\DataBundle\Entity\Frame;
use Zeega\DataBundle\Entity\Layer;
use Zeega\DataBundle\Entity\User;
use Zeega\CoreBundle\Helpers\ResponseHelper;
use Zeega\CoreBundle\Controller\BaseController;

class PublishController extends BaseController
{
    public function frameAction($id)
    {
        $frame = $this->getDoctrine()->getRepository("ZeegaDataBundle:Frame")->find($id);
        $layersId = $frame->getLayers();
        $layers = $this->getDoctrine()->getRepository("ZeegaDataBundle:Layer")->findByMultipleIds($layersId);
        $frameTemplate = $this->renderView("ZeegaApiBundle:Frames:show.json.twig", array("frame"=>$frame, "layers"=>$layers));

        return $this->render("ZeegaPublishBundle:Frame:frame.html.twig", array(
            "frameId"=> $frame->getId(),
            "frame"=>$frameTemplate,
            "layers"=>$layers
        ));
    }
     
    public function projectAction($id, $mobile)
    {       
        $projectItem = $this->getDoctrine()->getRepository("ZeegaDataBundle:Item")->findOneByIdWithUser($id);

        if(null !== $projectItem) {
            if($projectItem["mediaType"]=="project") {
                $projectData = $projectItem["text"];
            } 
        } 
        
        if (null === $projectItem || null === $projectData) {
            throw $this->createNotFoundException("The project with the id $id does not exist or is not published.");
        }



        $projectDataArray = json_decode($projectData, true);
            
        if( isset( $projectDataArray["version"] ) ){
           $projectVersion = $projectDataArray["version"]; 
        } else {
            $projectVersion = 1;
        }

        if ( $mobile ) {
            if ( $projectVersion < 1.1) {
                if( is_array($projectDataArray) && isset($projectDataArray["mobile"]) ){
                    
                    return $this->render("ZeegaPublishBundle:Player:mobile_player_1_0.html.twig", array(
                        "project"=>$projectItem,
                        "project_data" => $projectData,                
                    ));
                } else {

                    return $this->render("ZeegaPublishBundle:Player:mobile_not_supported.html.twig", array(
                        "project"=>$projectItem                
                    ));
                }
            } else {

                return $this->render("ZeegaPublishBundle:Player:mobile_player.html.twig", array(
                        "project"=>$projectItem,
                        "project_data" => $projectData,                
                    ));

            }    
        } else {
            
            if ( $projectVersion < 1.1) {
                return $this->render("ZeegaPublishBundle:Player:player_1_0.html.twig", array(
                    "project"=>$projectItem,
                    "project_data" => $projectData
                ));
            } else {
                return $this->render("ZeegaPublishBundle:Player:player.html.twig", array(
                    "project"=>$projectItem,
                    "project_data" => $projectData
                ));
            }
        }
    }

    public function projectPreviewAction($id)
    { 
        $project = $this->getDoctrine()->getRepository("ZeegaDataBundle:Project")->findOneById($id);
        $projectData = $this->forward("ZeegaApiBundle:Projects:getProject", array("id" => $id))->getContent();

        return $this->render("ZeegaPublishBundle:Player:player.html.twig", array(
            "project"=>$project,
            "project_data" => $projectData,
        ));
    }

     
    public function collectionAction($id)
    {
        $projectData = $this->forward("ZeegaApiBundle:Items:getItemProject", array("id" => $id))->getContent();
        $project = new Project();
        return $this->render("ZeegaPublishBundle:Player:player.html.twig", array(
            "project"=>$project,
            "project_data"=>$projectData,
        ));
    }


    public function channelAction($tag)
    {

        $params = array();
        //$params["data_source"] = "db";
        $params["sort"] = "date-desc";
        $params["type"] = "project";
        $params["tags"] = $tag;
        $projectData = $this->forward("ZeegaApiBundle:Items:getItemsSearch", array(), $params)->getContent();
        $project = new Project();

        return $this->render("ZeegaPublishBundle:Player:channel.html.twig", array(
            "project"=>$project,
            "project_data"=>$projectData,
        ));
    }
     
    public function embedAction ($id)
    {
        $projectItem = $this->getDoctrine()->getRepository("ZeegaDataBundle:Item")->findOneByIdWithUser($id);

        if(null !== $projectItem) {
            if($projectItem["mediaType"]=="project") {
                $projectData = $projectItem["text"];
            } 
        } 
        
        if (null === $projectItem || null === $projectData) {
            throw $this->createNotFoundException("The project with the id $id does not exist or is not published.");
        }



        $projectDataArray = json_decode($projectData, true);
            
        if( isset( $projectDataArray["version"] ) ){
           $projectVersion = $projectDataArray["version"]; 
        } else {
            $projectVersion = 1;
        }
        if ( $projectVersion < 1.1) {
            $project = $this->getDoctrine()->getRepository('ZeegaDataBundle:Item')->findOneById($id);
            if(is_object($project)&&$project->getMediaType()=='project'){}
            else  $project = $this->getDoctrine()->getRepository('ZeegaDataBundle:Project')->findOneById($id);

            $request = $this->getRequest();
            $author = $request->query->get('author');

            return $this->render('ZeegaPublishBundle:Player:embed_1_0.html.twig', array('project'=>$project, 'projectId'=>$id,'author'=>$author));
        } else {
            return $this->render("ZeegaPublishBundle:Player:embed.html.twig", array("project"=>$projectItem ));
        }
    }
}


