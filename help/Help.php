<?php

declare(strict_types=1);

namespace Help;

class Help {

    /**
     * Return messages of success or fail as a JSON string
     *
     * @param bool $status The status of the operation (true for success, false for failure)
     * @param string $message The message to return
     * @param int $code The status code associated with the message
     * @return string JSON encoded response
     */
    public function json(bool $status, string $message, int $code): string {
        return json_encode(
            [
                "data" => $status,
                "message" => $message,
                "code" => $code
            ]
        );
    }
}
