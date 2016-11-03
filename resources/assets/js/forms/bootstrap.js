/**
 * Load the IFC helper class.
 */
require('./form');

/**
 * Ifc error form class.
 */
require('./errors');

/**
 * Add additional HTTP / form helpers to the Spark object.
 */
$.extend(Ifc, require('./http'));
