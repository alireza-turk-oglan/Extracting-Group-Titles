<?php
class GroupTitle {
    private int $timeout;

    public function __construct(int $timeout = 15) {
        $this->timeout = $timeout;
    }

    /**
     *
     * @param string $url
     * @return string|null
     */
    public function getTitle(string $url): ?string {
        $html = $this->fetchHtml($url);
        if ($html === null) {
            return null;
        }

        if (strpos($url, 't.me') !== false || strpos($url, 'telegram.me') !== false) {
            return $this->extractTelegramTitle($html);
        }
        if (strpos($url, 'eitaa.com') !== false) {
            return $this->extractEitaaTitle($html);
        }
        if (strpos($url, 'chat.whatsapp.com') !== false) {
            return $this->extractWhatsappTitle($html);
        }

        return null;
    }
    private function fetchHtml(string $url): ?string {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; PHP script)',
            CURLOPT_ENCODING       => ''
        ]);
        $html = curl_exec($ch);
        $err  = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($html === false || $code >= 400) {
            error_log("fetchHtml error : http_code = {$code}, curl_error = {$err}");
            return null;
        }
        return $html;
    }

    private function extractTelegramTitle(string $html): ?string {
        return $this->extractOgTitle($html);
    }

    private function extractWhatsappTitle(string $html): ?string {
        return $this->extractOgTitle($html);
    }

    private function extractEitaaTitle(string $html): ?string {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        if (!$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html)) {
            libxml_clear_errors();
            return null;
        }
        $xpath = new DOMXPath($dom);

        $nodes = $xpath->query('/html/body/div[2]/div[2]/div/div[2]/span');
        if ($nodes->length > 0) {
            return trim($nodes->item(0)->textContent);
        }

        $nodes = $xpath->query('//div[contains(@class,"etme_page_title")]/span');
        if ($nodes->length > 0) {
            return trim($nodes->item(0)->textContent);
        }

        libxml_clear_errors();
        return null;
    }

    private function extractOgTitle(string $html): ?string {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        if (!$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html)) {
            libxml_clear_errors();
            return null;
        }
        $xpath = new DOMXPath($dom);
        $queries = [
            '//meta[@property="og:title"]/@content',
            '//meta[@name="og:title"]/@content',
            '//meta[@name="twitter:title"]/@content'
        ];
        foreach ($queries as $q) {
            $nodes = $xpath->query($q);
            if ($nodes->length > 0) {
                return trim($nodes->item(0)->nodeValue);
            }
        }
        libxml_clear_errors();
        return null;
    }
}
