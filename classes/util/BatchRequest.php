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
            if ( ($batch->ch[$id]=\curl_init()) === FALSE) {
                error_log("curl_init failed");
                return FALSE;
            } else if (\curl_setopt_array($batch->ch[$id], $options) === FALSE) {
                error_log("failed to set one or more cURL options!");
                return FALSE;
            } else if (\curl_setopt($batch->ch[$id], \CURLOPT_URL, $url) === FALSE) {
                error_log("failed to set CURLOPT_URL");
                return FALSE;
            }
        }

        if ( ($batch->mh=\curl_multi_init()) === FALSE) {
            error_log("curl_multi_init failed");
            return FALSE;
        } else {
            foreach ($batch->ch as $ch) {
                if (\curl_multi_add_handle($batch->mh, $ch) !== \CURLE_OK) {
                    error_log("{".curl_errno($ch)."} ".curl_error($ch));
                    return FALSE;
                }
            }
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
