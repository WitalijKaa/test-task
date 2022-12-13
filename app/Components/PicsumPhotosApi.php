<?php

namespace App\Components;

use App\Components\AbstractApiClient;

final class PicsumPhotosApi extends AbstractApiClient
{
    const API_IMAGE = '';
    const API_LIST = 'v2/list';

    const DEFAULT_LIMIT = 100;

    public function getNextId(int $id) {
        dd($this->getList(0, 1));
    }

    private function getList(int $id, int $page) { // 403 :(
        return $this->_sendGet(
            self::API_LIST . '/?' . http_build_query(['page' => $page, 'limit' => self::DEFAULT_LIMIT])
        );
    }

    protected function getServer() : string {
        return 'https://picsum.photos/';
    }

    protected function getHeaders() : array {
        return [];
    }

    //protected function responseFormatMode() { return static::RESPONSE_FORMAT_JSON; }
}
