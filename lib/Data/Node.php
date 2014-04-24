<?php
/**
 * Peanuts (http://peanuts.wubbobos.nl/)
 *
 * @link      http://github.com/wubdeveloper/peanuts for the canonical source repository
 * @copyright Copyright (c) 2014 Wubbo Bos (http://www.wubbobos.nl)
 * @license   https://gnu.org/licenses/gpl.html GNU Public License
 */

namespace Peanuts\Data;

class Node
{
	/**
	 * The parent node
	 *
	 * @var Node
	 */
	protected $_parent = null;

	/**
	 * The name of this node
	 *
	 * @var string
	 */
	protected $_name = '';

	/**
	 * The child nodes
	 *
	 * @var array
	 */
	protected $_children = array();

	/**
	 * Returns the node name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $name;
	}

	/**
	 * Constructor
	 *
	 * @param srting $name The name for this node
	 */
	public function __construct($name)
	{
		$this->_name = $name;
	}

	/**
	 * Appends a child to this node
	 *
	 * @param Node $child The child node to add
	 */
	public function appendChild($child)
	{
		$child->_parent = $this;
		$this->_children[] = $child;
	}

	/**
	 * Returns a string representation for this node
	 *
	 * @param integer $indent The indentation level
	 * @return string
	 */
	protected function _getStringRep($indent = 0)
	{
		$tabindent = str_repeat("  ", $indent);
		$str = $tabindent . $this->_name . "\n";

		if (count($this->_children) > 0)
		{
			foreach ($this->_children as $child) {
				$str .= $child->_getStringRep($indent + 1);
			}
		}

		return $str;
	}

	/**
	 * Returns a string representation for this node
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->_getStringRep();
	}
}