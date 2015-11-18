<?php

namespace oclc;

class WorldCatCatalogSearch {

	protected $idtype;
	protected $params;
	protected $api_path;

	private function __construct($idtype, $frbrgrouping) {
		$this->idtype = $idtype;
		$this->api_path = "http://www.worldcat.org/webservices/catalog/content/libraries";
        if ($idtype !== 'OCLC') {
            $this->api_path .= "/$idtype";
        }

		$this->params = \http_build_query(array(
			'oclcsymbol'=>\util\Config::$library->oclcsymbol,
            'wskey' => \util\Config::$library->wskey,
            'servicelevel' => 'full',
            'format' => 'json',
			'frbrgrouping' => $frbrgrouping
        ));
	}

    private function formatRequests($idlist) {
		$requests = array();
        foreach ($idlist as $id) {
            $requests[$id] =  "$this->api_path/$id?$this->params";
        }
        return $requests;
    }

    public static function getLinks($idtype,$idlist) {
		$urls = array();

		$wc = new WorldCatCatalogSearch($idtype,"off");
        $requests = $wc->formatRequests($idlist);
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

    public static function batchLookup($idtype, array $idlist, $hide_unique=false) {
		$failedIDs = array();
		$numSkippedIDs = 0;

        $resultset = array(
            'library' => array(
				'city'=>'',
				'state'=>'',
				'country'=>'',
				'postalcode'=>''),
            'query' => array(),
            'error' => "",
			'info' => "Rows highlighted in green indicate that a catalog url was found for the configured library."
        );

		$wc = new WorldCatCatalogSearch($idtype, "on");
		$requests = $wc->formatRequests($idlist);
        foreach ( \util\BatchRequest::make($requests)->exec() as $id=>$result ) {
            $result = json_decode($result,true);
			
            if (isset($result["diagnostic"])) {
				$failedIDs[] = $id;
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

				if (count($query['related']) || !$hide_unique) {
					$resultset['query'][] = $query;
				} else if ($hide_unique) {
					$numSkippedIDs++;
				}
            }
        }

        if (count($failedIDs)) {
            $resultset['error'] = "$idtype search failed for ID#s: " . implode(", ",$failedIDs);
        }

		if ($numSkippedIDs) {
			$resultset['info'] .= "<br>$numSkippedIDs ID#s were ignored...";
		}

        return  $resultset;
    }

}
