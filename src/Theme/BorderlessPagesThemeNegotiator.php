<?php

namespace Drupal\grid_pages\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;

/**
* Set the theme on Borderless Pages
*/
class BorderlessPagesThemeNegotiator implements ThemeNegotiatorInterface {

    /**
     * Determine if the current page should be rendered using the Borderless Theme
     *
     * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
     *   The current route match object.
     *
     * @return bool
     *   TRUE if the Borderless Theme is to be used, otherwise FALSE
     */
    public function applies(RouteMatchInterface $route_match) {
        $node = $route_match->getParameter('node');

        // return false if the current page is not a node
        if ($node == null || !($node instanceof Node))
            return false;

        $type = NodeType::load($node->getType());

        if ($type->getThirdPartySetting('grid_pages', 'only_on_node_view', 0)) {
            $parts = explode('/', $route_match->getRouteObject()->getPath());
            $count = count($parts) - 1; // -1 since the leading / causes [0] to be empty

            if ($count != 2 && $parts[$count] != 'view')
                return false;
        }

        return $type->getThirdPartySetting('grid_pages', 'is_borderless_page', 0);
    }

    /**
     * Returns the name of the Borderless Theme
     *
     * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
     *   The current route match object.
     *
     * @return string|null
     *   The name of the Borderless Theme or NULL if the module config happens to not contain a value
     */
    public function determineActiveTheme(RouteMatchInterface $route_match) {
        return \Drupal::config('grid_pages.settings')->get('theme_machine_name');
    }

}

