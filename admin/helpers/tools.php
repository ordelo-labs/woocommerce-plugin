<?php

/**
 * Converts a flat array of terms into a hierarchical tree structure.
 *
 * @param WP_Term[] $terms Terms to sort.
 * @param integer   $root_id Id of the term which is considered the root of the tree.
 *
 * @return array array of term data. Note the term data is an array,
 * rather than term object.
 */
function treeify_terms($terms, $root_id = 0)
{
    $tree = array();

    foreach ($terms as $term) {
        if ($term->parent === $root_id) {
            array_push(
                $tree,
                array(
                    'name'     => $term->name,
                    'slug'     => $term->slug,
                    'id'       => $term->term_id,
                    'count'    => $term->count,
                    'children' => treeify_terms($terms, $term->term_id),
                )
            );
        }
    }

    return $tree;
}
