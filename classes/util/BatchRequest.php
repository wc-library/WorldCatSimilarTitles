<?php

namespace util;

class BatchRequest {

    private $mh;
    private $ch;

    public static function make(array $requests) {
        $batch = new BatchRequest;

        $batch->ch = array();

        $options =  array(
            \CURLOPT_HEADER          => false,
            \CURLOPT_RETURNTRANSFER  => true,
            \CURLOPT_FAILONERROR     => true,
            \CURLOPT_VERBOSE         => false,
        );

        foreach ($requests as $id => $url) {
            $batch->ch[$id]=\curl_init();
            \curl_setopt_array($batch->ch[$id], $options);
            \curl_setopt($batch->ch[$id], \CURLOPT_URL, $url);
        }

        $batch->mh=\curl_multi_init();
        foreach ($batch->ch as $ch) {
            \curl_multi_add_handle($batch->mh, $ch);
        }

        return $batch;
    }

    public function exec() {
        $active = null;
        do {
            $mrc = \curl_multi_exec($this->mh, $active);
        } while ($mrc == \CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == \CURLM_OK) {
            if (\curl_multi_select($this->mh,1.0) == -1) {
                usleep(1);
            }

            do {
                $mrc = \curl_multi_exec($this->mh, $active);
            } while ($mrc == \CURLM_CALL_MULTI_PERFORM);
        }

        $responses = array();
        foreach ($this->ch as $id=>$ch) {
            $responses[$id] = \curl_multi_getcontent($ch);
            \curl_multi_remove_handle($this->mh, $ch);
            curl_close($ch);
        }
        curl_multi_close($this->mh);
        return $responses;
    }
}
