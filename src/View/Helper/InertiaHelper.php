<?php

declare(strict_types=1);

namespace Inertia\View\Helper;

use Cake\View\Helper;

/**
 * Inertia helper
 */
class InertiaHelper extends Helper
{
    /**
     * Returns inertia div.
     *
     * @param  array $pageData Page data to set into component.
     * @param  string $id Id attribute of the div.
     * @param  string $class Class attribute of the div.
     * @return string
     */
    public function make($pageData, $id = 'app', $class = ''): string
    {
        $encodedPageData = json_encode($pageData);

        if ($encodedPageData === false) {
            $encodedPageData = '';
        }

        return sprintf(
            '<script data-page="app" type="application/json">%s</script>' . PHP_EOL .
                '<div id="%s" class="%s"></div>',
            $encodedPageData,
            $id,
            $class
        );
    }
}
