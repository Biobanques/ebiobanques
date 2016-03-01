<?php

/**
 * Modified version of Proxy Adapter of Zend for easy integration
 * with Yii as extension.
 *
 * Copyright (c) 2005-2010, Zend Technologies USA, Inc.
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright notice,
 *       this list of conditions and the following disclaimer in the documentation
 *       and/or other materials provided with the distribution.
 * 
 *     * Neither the name of Zend Technologies USA, Inc. nor the names of its
 *       contributors may be used to endorse or promote products derived from this
 *       software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * HTTP Proxy-supporting EHttpClient adapter class, based on the default
 * socket based adapter.
 *
 * Should be used if proxy HTTP access is required. If no proxy is set, will
 * fall back to EHttpClientAdapterSocket behavior. Just like the
 * default Socket adapter, this adapter does not require any special extensions
 * installed.
 *
 * @category   Yii
 * @package    EHttp
 * @subpackage Client_Adapter
 */
class EProxy extends EHttpClientAdapterSocket {

	/**
	 * Parameters array
	 *
	 * @var array
	 */
	protected $config = array(
		'ssltransport' => 'ssl',
		'proxy_host' => '',
		'proxy_port' => 8080,
		'proxy_user' => '',
		'proxy_pass' => '',
		'proxy_auth' => EHttpClient::AUTH_BASIC,
		'persistent' => false
	);

	/**
	 * Whether HTTPS CONNECT was already negotiated with the proxy or not
	 *
	 * @var boolean
	 */
	protected $negotiated = false;

	/**
	 * Connect to the remote server
	 *
	 * Will try to connect to the proxy server. If no proxy was set, will
	 * fall back to the target server (behave like regular Socket adapter)
	 *
	 * @param string  $host
	 * @param int     $port
	 * @param boolean $secure
	 * @param int     $timeout
	 */
	public function connect($host, $port = 80, $secure = false)
	{
		// If no proxy is set, fall back to Socket adapter
		if (!$this->config['proxy_host'])
			return parent::connect($host, $port, $secure);

		// Go through a proxy - the connection is actually to the proxy server
		$host = $this->config['proxy_host'];
		$port = $this->config['proxy_port'];

		// If we are connected to the wrong proxy, disconnect first
		if (($this->connected_to[0] != $host || $this->connected_to[1] != $port))
		{
			if (is_resource($this->socket))
				$this->close();
		}

		// Now, if we are not connected, connect
		if (!is_resource($this->socket) || !$this->config['keepalive'])
		{
			$this->socket = @fsockopen($host, $port, $errno, $errstr, (int) $this->config['timeout']);
			if (!$this->socket)
			{
				$this->close();

				throw new EHttpClientException(
					Yii::t('EHttpClient', 'Unable to Connect to proxy server ' . $host . ':' . $port . '. Error #' . $errno . ': ' . $errstr));
			}

			// Set the stream timeout
			if (!stream_set_timeout($this->socket, (int) $this->config['timeout']))
			{
				throw new EHttpClientException(
					Yii::t('EHttpClient', 'Unable to set the connection timeout'));
			}

			// Update connected_to
			$this->connected_to = array($host, $port);
		}
	}

	/**
	 * Send request to the proxy server
	 *
	 * @param string        $method
	 * @param EUriHttp 		$uri
	 * @param string        $http_ver
	 * @param array         $headers
	 * @param string        $body
	 * @return string Request as string
	 */
	public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
	{
		// If no proxy is set, fall back to default Socket adapter
		if (!$this->config['proxy_host'])
			return parent::write($method, $uri, $http_ver, $headers, $body);

		// Make sure we're properly connected
		if (!$this->socket)
		{
			throw new EHttpClientException(
				Yii::t('EHttpClient', "Trying to write but we are not connected"));
		}

		$host = $this->config['proxy_host'];
		$port = $this->config['proxy_port'];

		if ($this->connected_to[0] != $host || $this->connected_to[1] != $port)
		{

			throw new EHttpClientException(
				Yii::t('EHttpClient', "Trying to write but we are connected to the wrong proxy server"));
		}

		// Add Proxy-Authorization header
		if ($this->config['proxy_user'] && !isset($headers['proxy-authorization']))
			$headers['proxy-authorization'] = EHttpClient::encodeAuthHeader(
					$this->config['proxy_user'], $this->config['proxy_pass'], $this->config['proxy_auth']
			);

		// if we are proxying HTTPS, preform CONNECT handshake with the proxy
		if ($uri->getScheme() == 'https' && (!$this->negotiated))
		{
			$this->connectHandshake($uri->getHost(), $uri->getPort(), $http_ver, $headers);
			$this->negotiated = true;
		}

		// Save request method for later
		$this->method = $method;

		// Build request headers
		$request = "{$method} {$uri->__toString()} HTTP/{$http_ver}\r\n";

		// Add all headers to the request string
		foreach ($headers as $k => $v)
		{
			if (is_string($k))
				$v = "$k: $v";
			$request .= "$v\r\n";
		}

		// Add the request body
		$request .= "\r\n" . $body;

		// Send the request
		if (!@fwrite($this->socket, $request))
		{

			throw new EHttpClientException(
				Yii::t('EHttpClient', "Error writing request to proxy server"));
		}

		return $request;
	}

	/**
	 * Preform handshaking with HTTPS proxy using CONNECT method
	 *
	 * @param string  $host
	 * @param integer $port
	 * @param string  $http_ver
	 * @param array   $headers
	 */
	protected function connectHandshake($host, $port = 443, $http_ver = '1.1', array &$headers = array())
	{
		$request = "CONNECT $host:$port HTTP/$http_ver\r\n" .
			"Host: " . $this->config['proxy_host'] . "\r\n";

		// Add the user-agent header
		if (isset($this->config['useragent']))
		{
			$request .= "User-agent: " . $this->config['useragent'] . "\r\n";
		}

		// If the proxy-authorization header is set, send it to proxy but remove
		// it from headers sent to target host
		if (isset($headers['proxy-authorization']))
		{
			$request .= "Proxy-authorization: " . $headers['proxy-authorization'] . "\r\n";
			unset($headers['proxy-authorization']);
		}

		$request .= "\r\n";

		// Send the request
		if (!@fwrite($this->socket, $request))
		{
			throw new EHttpClientException(
				Yii::t('EHttpClient', "Error writing request to proxy server"));
		}

		// Read response headers only
		$response = '';
		$gotStatus = false;
		while ($line = @fgets($this->socket))
		{
			$gotStatus = $gotStatus || (strpos($line, 'HTTP') !== false);
			if ($gotStatus)
			{
				$response .= $line;
				if (!chop($line))
					break;
			}
		}

		// Check that the response from the proxy is 200
		if (EHttpResponse::extractCode($response) != 200)
		{
			throw new EHttpClientException(
				Yii::t('EHttpClient', "Unable to connect to HTTPS proxy. Server response: " . $response));
		}

		// If all is good, switch socket to secure mode. We have to fall back
		// through the different modes 
		$modes = array(
			STREAM_CRYPTO_METHOD_TLS_CLIENT,
			STREAM_CRYPTO_METHOD_SSLv3_CLIENT,
			STREAM_CRYPTO_METHOD_SSLv23_CLIENT,
			STREAM_CRYPTO_METHOD_SSLv2_CLIENT
		);

		$success = false;
		foreach ($modes as $mode)
		{
			$success = stream_socket_enable_crypto($this->socket, true, $mode);
			if ($success)
				break;
		}

		if (!$success)
		{
			throw new EHttpClientException(
				Yii::t('EHttpClient', "Unable to connect to" .
					" HTTPS server through proxy: could not negotiate secure connection."));
		}
	}

	/**
	 * Close the connection to the server
	 *
	 */
	public function close()
	{
		parent::close();
		$this->negotiated = false;
	}

	/**
	 * Destructor: make sure the socket is disconnected
	 *
	 */
	public function __destruct()
	{
		if ($this->socket)
			$this->close();
	}

}
