<?php

namespace App\Service;

use App\Entity\Line;
use App\Entity\Node;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseService
{
    /**
     * @var array
     */
    private $listLines = [];

    /**
     * @var EntityManagerInterface
     */
    private  $em;

    /**
     * @param EntityManagerInterface $em
     */
   public function __construct( EntityManagerInterface $em){

       $this->em = $em;
   }

    /**
     * Allows data to be stored in the database
     * @param array $AllCsvDataAsArray
     * @return void
     */
public function load(array $AllCsvDataAsArray){


    foreach ($AllCsvDataAsArray as $data) {
      //Creste Nodes entities andpersist data
        $node = new Node();
        $node->setIsTerminus( $data[ "termetro"] );
        $this->em->persist($node);


            // create Line entities
              if(key_exists($this->getCorrectId($data['ligne']), $this->listLines)) {
                  $this->listLines[$this->getCorrectId($data['ligne'])]->addNode($node);
                 // $this->em->persist($this->listLines[$data[ "ligne" ]]);
              }else{
                  $line = new Line();
                  $line
                      ->setId($this->getCorrectId($data['ligne']) )
                      ->setName($data[ "ligne" ])
                      ->setCodeResf($data[ "cod_resf"])
                      ->setCodLigf($data[ "cod_ligf" ])
                      ->setIdrefliga($data[ "idrefliga" ])
                      ->setIdrefligc($data[ "idrefligc" ])
                      ->setResCom($data[ "res_com" ])
                      ->addNode($node)
                  ;
                  $this->listLines[$this->getCorrectId($data['ligne'])] = $line;
                  $this->em->persist($line);
              }

               // create Station entities
                $station = new Station();
                ;
                $station->setId($data[ "gares_id"])
                    ->setName($data[ "nom_gare" ])
                    ->setGeoPoint($data["Geo Point"])
                    ->setMain($data[ "principal"])
                    ->setNameIv($data["nom_iv" ])
                    ->setNameLong($data[ "nomlong" ])
                    ->setNameStation($data["nom_gare"])
                    ->setX($data[ "x"])
                    ->setY($data[ "y"])
                    ->addNode($node)
                ;
                $this->em->persist($station);
    }
  $this->em->flush();
}

    /**
     * correct Id and create numeric one
     * @param $id
     * @return int
     */
    private function  getCorrectId($id){
       if( is_numeric($id)){
           return (int)$id;
       }elseif($id ==='7b'){
           return 15;
       }else{
           return 17;
       }


    }
}