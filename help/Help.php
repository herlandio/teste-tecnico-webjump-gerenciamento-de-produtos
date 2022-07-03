<?php


namespace Help;


class Help {

    /**
     * Return messages of success or fail
     * @param $status
     * @param $message
     * @param $code
     * @return false|string
     */
    public function JSON($status, $message, $code) {
        return json_encode(
            [
                "data" => $status,
                "message" => $message,
                "code" => $code
            ]
        );
    }

}