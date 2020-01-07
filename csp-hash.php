<?php
declare(strict_types=1);
define('VERBOSE', false);

$file = $argv[1] ?? 'https://spiro.se/';

echo '# FILE: ', $file, ' #', PHP_EOL;

$d = new DomDocument();
@$d->loadHTMLFile($file);
$xpath = new DOMXpath($d);

$head_styles = $xpath->query('/html/head/style');
echo '# styles in head: ', $head_styles->length, PHP_EOL;
if($head_styles->length > 0) {
    /** @var DOMNode $head_style */
    foreach($head_styles as $head_style) {
        $src = $head_style->attributes->getNamedItem('src');
        if($src && $src->textContent) {
            if(VERBOSE) {
                echo '## skipping style with source: ', $src->textContent, PHP_EOL;
            }
            continue;
        }
        $hash = base64_encode(hash('sha256', $head_style->textContent, true));
        $filename = 'hashes/' . strtr($hash, ['/' => '_']) . '.css';
        file_put_contents(__DIR__ . '/' . $filename, $head_style->textContent);
        echo 'sha256-', $hash, ' (', $filename, ')', PHP_EOL;
    }
}


$body_styles = $xpath->query('/html/body//style');
echo '# styles in body: ', $body_styles->length, PHP_EOL;
if($body_styles->length > 0) {
    /** @var DOMNode $head_style */
    foreach($body_styles as $body_style) {
        $src = $body_style->attributes->getNamedItem('src');
        if($src && $src->textContent) {
            if(VERBOSE) {
                echo '## skipping style with source: ', $src->textContent, PHP_EOL;
            }
            continue;
        }
        $hash = base64_encode(hash('sha256', $body_style->textContent, true));
        $filename = 'hashes/' . strtr($hash, ['/' => '_']) . '.css';
        file_put_contents(__DIR__ . '/' . $filename, $body_style->textContent);
        echo 'sha256-', $hash, ' (', $filename, ')', PHP_EOL;
    }
}

$head_scripts = $xpath->query('/html/head/script');
echo '# scripts in head: ', $head_scripts->length, PHP_EOL;
if($head_scripts->length > 0) {
    /** @var DOMNode $head_script */
    foreach($head_scripts as $head_script) {
        $src = $head_script->attributes->getNamedItem('src');
        if($src && $src->textContent) {
            if(VERBOSE) {
                echo '## skipping script with source: ', $src->textContent, PHP_EOL;
            }
            continue;
        }
        $type = $head_script->attributes->getNamedItem('type');
        if($type && $type->textContent && strtolower($type->textContent) !== 'script/javascript') {
            if(VERBOSE) {
                echo '## skipping script with unknown type: ', $type->textContent, PHP_EOL;
            }
            continue;
        }
        $hash = base64_encode(hash('sha256', $head_script->textContent, true));
        $filename = 'hashes/' . strtr($hash, ['/' => '_']) . '.js';
        file_put_contents(__DIR__ . '/' . $filename, $head_script->textContent);
        echo 'sha256-', $hash, ' (', $filename, ')', PHP_EOL;
    }
}


$body_scripts = $xpath->query('/html/body//script');
echo '# scripts in body: ', $body_scripts->length, PHP_EOL;
if($body_scripts->length > 0) {
    /** @var DOMNode $body_script */
    foreach($body_scripts as $body_script) {
        $src = $body_script->attributes->getNamedItem('src');
        if($src && $src->textContent) {
            if(VERBOSE) {
                echo '## skipping script with source: ', $src->textContent, PHP_EOL;
            }
            continue;
        }
        $type = $body_script->attributes->getNamedItem('type');
        if($type && $type->textContent && strtolower($type->textContent) !== 'text/javascript') {
            if(VERBOSE) {
                echo '## skipping script with unknown type: ', $type->textContent, PHP_EOL;
            }
            continue;
        }
        $hash = base64_encode(hash('sha256', $body_script->textContent, true));
        $filename = 'hashes/' . strtr($hash, ['/' => '_']) . '.js';
        file_put_contents(__DIR__ . '/' . $filename, $body_script->textContent);
        echo 'sha256-', $hash, ' (', $filename, ')', PHP_EOL;
    }
}
