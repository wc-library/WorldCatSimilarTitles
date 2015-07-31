<?php
/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */

namespace WorldCat {
    class XIDService {
        protected $idType;
        protected $url;

        public function construct($idType) {
            $this->idType = urlencode($idType);
            $this->url = "http://x{$idType}.worldcat.org/webservices/xid/{$idType}/";
        }

        /**
         * @param int $id An isbn or issn id
         * @return array An array containing related IDs
         */
        public function getEditions($id) {
            $request = $this->genRequestURL(array(
                'identifier' => $id,
                'method' => 'getEditions',
                'format' => 'xml',
                'fl' => $this->idType
            ));

            $response = file_get_contents($request);
            $xml = new \SimpleXMLElement($response);

            return $xml->{$this->idType};
        }

        protected function genRequestURL(array $params) {
            $id = $params['identifier'];
            unset($params['identifier']);
            
            return $this->url.$id.'?'.http_build_query($params);
        }
    }
}

namespace {
    class WorldCatService {
        public $isbn;
        public $issn;

        public function __construct() {
            $this->isbn = new \WorldCat\XIDService("isbn");
            $this->issn = new \WorldCat\XIDService("issn");
        }
    }
}
