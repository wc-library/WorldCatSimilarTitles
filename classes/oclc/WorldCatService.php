<?php

namespace oclc;

class WorldCatService {

    public function batchLookup($idtype, array $idlist, $includeRelated=true) {
        $idtype = strtoupper($idtype);
        $params = array(
            'oclcsymbol'=>\util\Config::$library->oclcsymbol,
            'wskey' => \util\Config::$library->wskey,
            'servicelevel' => 'full',
            'format' => 'json',
            'frbrGrouping' => ($includeRelated)?'on':'off'
        );

        $resultset = array(
            'query' => array()
        );
        $i=0;
        foreach ( \oclc\services\Catalog::batchQuery($idtype,$idlist,$params) as $id=>$result ) {
            $result = (array)json_decode($result);
            $query = array(
                '@attributes' => array($idtype=>"$id"),
                'title'       => $result['title'],
                'author'      => $result['author'],
                'publisher'   => $result['publisher'],
                'related'     => array($idtype=>array())
            );
            foreach ($result[$idtype] as $relatedID) {
                $query['related'][$idtype][] = $relatedID;
            }
            $resultset['query'][] = $query;
            ++$i;
        }
        return  $resultset;
    }

}
