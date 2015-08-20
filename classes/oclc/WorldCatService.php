<?php

namespace oclc;

class WorldCatService {

    protected function formatRequestURL($api_path,$id,$params) {
        return "http://www.worldcat.org/webservices".$api_path."/$id?".\http_build_query($params);
    }

    public function ajaxGetRelatedLinks($idtype, $related_ids) {
        $params = array(
            'oclcsymbol'=>\util\Config::$library->oclcsymbol,
            'wskey' => \util\Config::$library->wskey,
            'servicelevel' => 'full',
            'format' => 'json',
            'frbrGrouping' => 'off'
        );

        $api_path = "/catalog/content/libraries/";
        if ($idtype !== 'OCLC') {
            $api_path .= $idtype;
        }

        $requests = array();
        foreach ($related_ids as $id) {
            $requests[$id] =  $this->formatRequestURL($api_path, $id, $params);
        }
        $urls = array();
        foreach ( \util\BatchRequest::make($requests)->exec() as $id=>$result ) {
            $result = json_decode($result,true);
            if (!isset($result["diagnostic"])) {
                if (isset($result['library'][0])) {
                    $libInfo = $result['library'][0];
                    if (isset($libInfo['opacUrl'])) {
                        $urls[$id] = $libInfo['opacUrl'];
                    }
                }
            }
            if (!array_key_exists($id,$urls)) {
                $urls[$id] = FALSE;
            }
        }
        return $urls;
    }

    public function batchLookup($idtype, array $idlist, $includeRelated=true) {
        $resultset = array(
            'library' => array(),
            'query' => array(),
            'error' => array(),
            'errormsg' => null
        );

        $params = array(
            'oclcsymbol'=>\util\Config::$library->oclcsymbol,
            'wskey' => \util\Config::$library->wskey,
            'servicelevel' => 'full',
            'format' => 'json',
            'frbrGrouping' => ($includeRelated)?'on':'off'
        );

        $api_path = "/catalog/content/libraries/";
        if ($idtype !== 'OCLC') {
            $api_path .= $idtype;
        }

        $requests = array();
        foreach ($idlist as $id) {
            $requests[$id] =  $this->formatRequestURL($api_path, $id, $params);
        }

        foreach ( \util\BatchRequest::make($requests)->exec() as $id=>$result ) {
            $result = json_decode($result,true);
            if (isset($result["diagnostic"])) {
                $resultset['error'][] = $id;
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
                    'related'     => array(),
                );

                if (isset($result[$idtype]) && is_array($result[$idtype])) {
                    $query['related'] = $result[$idtype];

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
        }

        if (count($resultset['error'])) {
            $resultset['errormsg'] = "$idtype search failed for ID#s: " . implode(", ",$resultset['error']);
        }

        return  $resultset;
    }

}
