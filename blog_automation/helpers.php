<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function slugify(string $text): string
{
    $text = trim(mb_strtolower($text));
    $text = preg_replace('/[^a-z0-9]+/u', '-', $text) ?? '';
    $text = trim($text, '-');

    return $text !== '' ? $text : 'blog';
}

function excerpt(string $text, int $length = 150): string
{
    $text = trim(html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

    if (mb_strlen($text) <= $length) {
        return $text;
    }

    return rtrim(mb_substr($text, 0, $length - 3)) . '...';
}

function calculateReadTime(string $content): string
{
    $wordCount = str_word_count(html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $minutes = max(1, (int) ceil($wordCount / 200));

    return $minutes . ' MIN READ';
}

function formatBlogDate(string $dateTime): string
{
    $timestamp = strtotime($dateTime);

    return $timestamp ? date('F j, Y', $timestamp) : $dateTime;
}

function isAbsoluteUrl(string $path): bool
{
    return (bool) preg_match('/^(https?:)?\/\//i', $path);
}

function startsWithSchemeLike(string $path): bool
{
    return (bool) preg_match('/^(mailto:|tel:|javascript:|data:|#)/i', $path);
}

function normalizePathSegments(string $path): string
{
    $segments = explode('/', str_replace('\\', '/', $path));
    $output = [];

    foreach ($segments as $segment) {
        if ($segment === '' || $segment === '.') {
            continue;
        }

        if ($segment === '..') {
            array_pop($output);
            continue;
        }

        $output[] = $segment;
    }

    return implode('/', $output);
}

function joinRelativeUrl(string $base, string $relative): string
{
    if ($relative === '') {
        return $base;
    }

    if (isAbsoluteUrl($relative) || startsWithSchemeLike($relative) || str_starts_with($relative, '/')) {
        return $relative;
    }

    $relative = normalizePathSegments($relative);

    if (isAbsoluteUrl($base)) {
        $parts = parse_url($base);
        if ($parts === false || !isset($parts['scheme'], $parts['host'])) {
            return $relative;
        }

        $path = $parts['path'] ?? '/';
        $path = rtrim(str_replace('\\', '/', dirname($path)), '/');
        $prefix = $parts['scheme'] . '://' . $parts['host'];

        if (isset($parts['port'])) {
            $prefix .= ':' . $parts['port'];
        }

        return $prefix . ($path !== '' ? $path : '') . '/' . $relative;
    }

    return rtrim($base, '/') . '/' . $relative;
}

function normalizeResourcePath(string $value, string $uploadDirectoryUrl, ?string $baseHref = null): string
{
    $value = trim($value);

    if ($value === '' || startsWithSchemeLike($value) || str_starts_with($value, '/')) {
        return $value;
    }

    if (isAbsoluteUrl($value)) {
        return $value;
    }

    if ($baseHref !== null && $baseHref !== '') {
        return joinRelativeUrl($baseHref, $value);
    }

    return joinRelativeUrl($uploadDirectoryUrl, $value);
}

function innerHtml(DOMNode $node): string
{
    $html = '';

    foreach ($node->childNodes as $childNode) {
        $html .= $node->ownerDocument->saveHTML($childNode);
    }

    return $html;
}

function getMetaDescription(DOMDocument $dom): string
{
    $metaTags = $dom->getElementsByTagName('meta');

    foreach ($metaTags as $metaTag) {
        $name = strtolower(trim((string) $metaTag->getAttribute('name')));
        if ($name === 'description') {
            return trim((string) $metaTag->getAttribute('content'));
        }
    }

    return '';
}

function getFirstElementText(DOMDocument $dom, string $tagName): string
{
    $elements = $dom->getElementsByTagName($tagName);

    if ($elements->length === 0) {
        return '';
    }

    return trim((string) $elements->item(0)?->textContent);
}

function removeFirstImageFromBody(DOMDocument $dom): void
{
    $bodyNodes = $dom->getElementsByTagName('body');

    if ($bodyNodes->length === 0 || $bodyNodes->item(0) === null) {
        return;
    }

    $images = $bodyNodes->item(0)->getElementsByTagName('img');

    if ($images->length === 0 || $images->item(0) === null) {
        return;
    }

    $firstImage = $images->item(0);
    $parentNode = $firstImage->parentNode;

    if ($parentNode !== null) {
        $parentNode->removeChild($firstImage);
    }
}

function rewriteBodyResources(DOMDocument $dom, string $uploadDirectoryUrl, ?string $baseHref = null): void
{
    $attributeMap = [
        'img' => ['src'],
        'source' => ['src', 'srcset'],
        'video' => ['poster', 'src'],
        'audio' => ['src'],
        'iframe' => ['src'],
        'a' => ['href'],
        'link' => ['href'],
    ];

    foreach ($attributeMap as $tagName => $attributes) {
        $elements = $dom->getElementsByTagName($tagName);

        foreach ($elements as $element) {
            foreach ($attributes as $attribute) {
                if (!$element->hasAttribute($attribute)) {
                    continue;
                }

                $originalValue = trim((string) $element->getAttribute($attribute));
                if ($originalValue === '') {
                    continue;
                }

                if ($attribute === 'srcset') {
                    $entries = array_map('trim', explode(',', $originalValue));
                    $rewrittenEntries = [];

                    foreach ($entries as $entry) {
                        if ($entry === '') {
                            continue;
                        }

                        $parts = preg_split('/\s+/', $entry, 2);
                        $path = $parts[0] ?? '';
                        $descriptor = $parts[1] ?? '';
                        $normalized = normalizeResourcePath($path, $uploadDirectoryUrl, $baseHref);
                        $rewrittenEntries[] = trim($normalized . ' ' . $descriptor);
                    }

                    $element->setAttribute($attribute, implode(', ', $rewrittenEntries));
                    continue;
                }

                $element->setAttribute(
                    $attribute,
                    normalizeResourcePath($originalValue, $uploadDirectoryUrl, $baseHref)
                );
            }
        }
    }
}

function extractBlogDataFromHtml(string $html, string $uploadDirectoryUrl): array
{
    libxml_use_internal_errors(true);

    $dom = new DOMDocument('1.0', 'UTF-8');
    $loaded = $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOWARNING | LIBXML_NOERROR);

    libxml_clear_errors();

    if ($loaded === false) {
        throw new RuntimeException('Unable to parse the uploaded HTML file.');
    }

    $baseHref = '';
    $baseTags = $dom->getElementsByTagName('base');
    if ($baseTags->length > 0) {
        $baseHref = trim((string) $baseTags->item(0)?->getAttribute('href'));
    }

    rewriteBodyResources($dom, $uploadDirectoryUrl, $baseHref !== '' ? $baseHref : null);

    $title = getFirstElementText($dom, 'title');
    if ($title === '') {
        $title = getFirstElementText($dom, 'h1');
    }
    if ($title === '') {
        $title = 'Untitled Blog';
    }

    $metaDescription = getMetaDescription($dom);

    $images = $dom->getElementsByTagName('img');
    $thumbnail = '';
    if ($images->length > 0) {
        $thumbnail = trim((string) $images->item(0)?->getAttribute('src'));
    }

    if ($thumbnail !== '') {
        removeFirstImageFromBody($dom);
    }

    $bodyNodes = $dom->getElementsByTagName('body');
    $content = '';
    if ($bodyNodes->length > 0 && $bodyNodes->item(0) !== null) {
        $content = trim(innerHtml($bodyNodes->item(0)));
    }

    if ($content === '') {
        $content = trim($html);
    }

    if ($metaDescription === '') {
        $metaDescription = excerpt($content, 200);
    }

    return [
        'title' => $title,
        'meta_description' => $metaDescription,
        'thumbnail' => $thumbnail,
        'content' => $content,
        'read_time' => calculateReadTime($content),
    ];
}
