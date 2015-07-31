<?php

namespace WorldCat {
    class XIDService {
    }
}

namespace {
    class WorldCatService {
        public $xID;
        
        public function __construct() {
            $this->xID = new \WorldCat\XIDService();
        }
    }
}
