<?php
/**
 * File containing DomainObjectInterface interface
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 * @package ezp
 * @subpackage base
 */

/**
 * Interface for content domain objects
 */
namespace ezp\base;
interface ModelInterface
{
    /**
     * Returns an instance of the desired object, initialized from $state.
     *
     * This method must return a new instance of the class it is implemented
     * in, which has its properties set from the given $state array.
     *
     * @param array $state
     * @return ModelInterface
     */
    public static function __set_state( array $state );
}
?>
