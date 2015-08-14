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
            'library' => array(),
            'query' => array()
        );

        foreach ( \oclc\services\Catalog::batchQuery($idtype,$idlist,$params) as $id=>$result ) {
            $result = json_decode($result,true);
            if (isset($result["diagnostic"])) {
                error_log("Catalog search failed for $idtype/$id");
            } else {
                $query = array(
                    '@attributes' => array('idtype'=>$idtype),
                    'id'          => $id,
                    'title'       => $result['title'],
                    'author'      => $result['author'],
                    'publisher'   => $result['publisher'],
                    'date'        => $result['date'],
                    'OCLCnumber'  => $result['OCLCnumber'],
                    'url'         => "",
                    'related'     => $result[$idtype],
                );

                if(($key = array_search($id,$query['related'])) !== false) {
                    unset($query['related'][$key]);
                }
                
                if (isset($result['library'][0])) {
                    $libInfo = $result['library'][0];
                    if (isset($libInfo['opacUrl'])) {
                        $query['url'] = $libInfo['opacUrl'];
                    }

                    if (isset($libInfo['institutionName']) && !isset($resultset['library']['institutionName'])) {
                        $resultset['library'] = array(
                            'institutionName' => $libInfo['institutionName'],
                            'oclcSymbol'      => $libInfo['oclcSymbol'],
                            'city'            => $libInfo['city'],
                            'state'           => $libInfo['state'],
                            'country'         => $libInfo['country'],
                            'postalCode'      => $libInfo['postalCode']
                        );
                    }
                } else {
                    $query['library'] = 'Holding not found!';
                }

                if (count($query['related'])) {
                    $resultset['query'][] = $query;
                }
            }
        }
        return  $resultset;
    }

}
