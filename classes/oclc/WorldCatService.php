<?php
/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */

namespace oclc;
class WorldCatService {
    public function __construct($libraryName) {
        $this->library = new \input\Library($libraryName);
        $this->xid = new \oclc\services\XID($this->library);
        $this->catalog = new \oclc\services\Catalog($this->library);
    }
}