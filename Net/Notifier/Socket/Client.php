<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

require_once 'Net/Notifier/Socket/Abstract.php';

class Net_Notifier_Socket_Client
    extends Net_Notifier_Socket_Abstract
{
    /**
     * Class constructor, tries to establish connection
     *
     * @param string  $address    Address for stream_socket_client() call,
     *                            e.g. 'tcp://localhost:80'.
     * @param integer $timeout    Connection timeout (seconds).
     * @param array   $sslOptions SSL context options.
     *
     * @throws Net_Notifier_Socket_ConnectionException
     */
    public function __construct($address, $timeout, array $sslOptions = array())
    {
        $context = stream_context_create();
        foreach ($sslOptions as $name => $value) {
            if (!stream_context_set_option($context, 'ssl', $name, $value)) {
                throw new Net_Notifier_Socket_ConnectionException(
                    "Error setting SSL context option '{$name}'"
                );
            }
        }

        set_error_handler(array($this, 'connectionWarningsHandler'));

        $this->socket = stream_socket_client(
            $address,
            $errno,
            $errstr,
            $timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        restore_error_handler();

        if (!$this->socket) {
            $error = ($errstr == '')
                ? implode("\n", $this->connectionWarnings)
                : $errstr;

            throw new Net_Notifier_Socket_ConnectionException(
                "Unable to connect to {$address}. Error: {$error}",
                0,
                $errno
            );
        }
    }
}

?>