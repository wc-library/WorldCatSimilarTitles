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
        $i=0;
        foreach ( \oclc\services\Catalog::batchQuery($idtype,$idlist,$params) as $id=>$result ) {
            $result = \util\Utility::objectToArray(json_decode($result));
            $query = array(
                '@attributes' => array($idtype=>"$id"),
                'title'       => $result['title'],
                'author'      => $result['author'],
                'publisher'   => $result['publisher'],
                'date'        => $result['date'],
                'related'     => array($idtype=>array()),
                'OCLCnumber'  => $result['OCLCnumber'],
            );

            foreach ($result[$idtype] as $relatedID) {
                $query['related'][$idtype][] = $relatedID;
            }

            if (isset($result['library'][0])) {
                $libInfo = $result['library'][0];
                if (isset($libInfo['opacUrl'])) {
                    $query['opacUrl'] = $libInfo['opacUrl'];
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

            $resultset['query'][] = $query;
            ++$i;
        }
        return  $resultset;
    }

}
