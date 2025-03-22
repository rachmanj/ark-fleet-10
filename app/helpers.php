<?php

if (!function_exists('correct_asset_url')) {
    /**
     * Generate a correct asset URL that works in both local and production environments
     *
     * @param string $path
     * @return string
     */
    function correct_asset_url($path)
    {
        // Get the base URL from environment
        $baseUrl = rtrim(config('app.url'), '/');

        // Clean the path
        $path = ltrim($path, '/');

        // Check if we're in a subfolder installation
        if (strpos($baseUrl, '/ark-fleet') !== false) {
            // We're in a subfolder, ensure 'public' is in the path if needed
            if (strpos($baseUrl, '/public') === false && strpos($path, 'public/') === false) {
                return $baseUrl . '/public/' . $path;
            }
        }

        return $baseUrl . '/' . $path;
    }
}

if (!function_exists('correct_route_url')) {
    /**
     * Generate a correct route URL that works in both local and production environments
     *
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function correct_route_url($name, $parameters = [], $absolute = true)
    {
        $url = route($name, $parameters, $absolute);

        // Fix subfolder installations with incorrect base URLs
        $baseUrl = rtrim(config('app.url'), '/');
        if (strpos($baseUrl, '/ark-fleet') !== false && strpos($url, '/ark-fleet') === false) {
            $urlParts = parse_url($url);
            $path = isset($urlParts['path']) ? $urlParts['path'] : '';

            // Check if we need to insert the subfolder path
            if (strpos($path, '/ark-fleet') === false) {
                $baseUrlParts = parse_url($baseUrl);
                $subfolderPath = isset($baseUrlParts['path']) ? $baseUrlParts['path'] : '';

                // Replace the path with the correct subfolder path
                $newPath = $subfolderPath . $path;

                // Rebuild the URL
                $scheme = isset($urlParts['scheme']) ? $urlParts['scheme'] . '://' : '';
                $host = isset($urlParts['host']) ? $urlParts['host'] : '';
                $port = isset($urlParts['port']) ? ':' . $urlParts['port'] : '';
                $query = isset($urlParts['query']) ? '?' . $urlParts['query'] : '';
                $fragment = isset($urlParts['fragment']) ? '#' . $urlParts['fragment'] : '';

                return $scheme . $host . $port . $newPath . $query . $fragment;
            }
        }

        return $url;
    }
}
