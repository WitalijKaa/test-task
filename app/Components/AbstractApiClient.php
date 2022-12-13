<?php

namespace App\Components;

/**
 * Удобная отправка запросов к стороннему апи с curl
 *
 * Class AbstractApiClient
 * @package App\Components
 */
abstract class AbstractApiClient {

    const CONTENT_TYPE_JSON = 'application/json';
    const RESPONSE_FORMAT_JSON = 'rf_json';
    protected function responseFormatMode() { return ''; }

    protected $_lastError = '';
    public function getLastError() {
        if (is_array($this->_lastError)) {
            return preg_replace("[\r\n]"," ", json_encode($this->_lastError, JSON_UNESCAPED_UNICODE));
        }
        return preg_replace("[\r\n]"," ", $this->_lastError);
    }
    public function hasErrors() : bool { return !!$this->_lastError; }

    /**
     * @return string часть запроса начинающаяся с ?
     */
    protected function getQueryParams() : string { return ''; }

    /**
     * @return array специфичные пары для curl_setopt($ch, $optName, $optVal) ключ массива это $optName значение это $optVal
     */
    protected function getCurlOptions() : array {
        return [];
    }

    abstract protected function getHeaders() : array;
    abstract protected function getServer() : string;

    protected function _sendPost($body, ?string $contentType = null, ?string $path = null) {
        $this->beforeCurl($path);
        $headers = $contentType ? array_merge($this->getHeaders(), ['Content-Type: ' . $contentType]) : $this->getHeaders();
        if ($headers) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $body);
        $this->chResponse = curl_exec($this->ch);
        $this->afterCurl();
        return $this->chResponse;
    }

    protected function _sendPut($body, ?string $contentType = null, ?string $path = null) {
        $this->beforeCurl($path);
        $headers = $contentType ? array_merge($this->getHeaders(), ['Content-Type: ' . $contentType]) : $this->getHeaders();
        if ($headers) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $body);
        $this->chResponse = curl_exec($this->ch);
        $this->afterCurl();
        return $this->chResponse;
    }

    protected function _sendGet(?string $path = null)
    {
        $this->beforeCurl($path);
        if ($this->getHeaders()) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        }
        $this->chResponse = curl_exec($this->ch);
        $this->afterCurl();
        return $this->chResponse;
    }

    protected function _sendDelete(?string $path = null)
    {
        $this->beforeCurl($path);
        if ($this->getHeaders()) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        }
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->chResponse = curl_exec($this->ch);
        $this->afterCurl();
        return $this->chResponse;
    }

    private $ch;
    private $chResponse;
    private function beforeCurl(?string $path = null) {
        $this->_lastError = '';
        $this->ch = curl_init($this->getServer() . $path . $this->getQueryParams());
        foreach ($this->getCurlOptions() as $optName => $optVal) {
            curl_setopt($this->ch, $optName, $optVal);
        }
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }
    private function afterCurl() {
        $code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
        if ($code > 299 || $code < 200) {
            $curlError = curl_error($this->ch);
            $this->_lastError = $curlError ? $curlError : "code is $code ## ";

            if ($this->chResponse) {
                $this->_lastError .= $this->chResponse;
            }
        }

        curl_close($this->ch);
        $this->ch = null;

        if (!$this->hasErrors() && $this->responseFormatMode() === static::RESPONSE_FORMAT_JSON) {
            $this->chResponse = json_decode($this->chResponse, 1);
        }
    }

    protected function jsonBody(array $body) : string { return json_encode($body, JSON_UNESCAPED_UNICODE); }
}
