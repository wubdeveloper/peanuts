<?php
/**
 * Peanuts (http://peanuts.wubbobos.nl/)
 *
 * @link      http://github.com/wubdeveloper/peanuts for the canonical source repository
 * @copyright Copyright (c) 2014 Wubbo Bos (http://www.wubbobos.nl)
 * @license   https://gnu.org/licenses/gpl.html GNU Public License
 */

namespace Platform\Data;

class Tree
{
	/**
	 * The root node
	 *
	 * @var Node
	 */
	protected $_root;

	/**
	 * The top node of the node stack
	 *
	 * @var Node
	 */
	protected $_top;

	/**
	 * The depth stack for tree construction
	 *
	 * @var array
	 */
	protected $_stack;

	/**
	 * Constructor
	 *
	 * @param Node $root The root node
	 */
	public function __construct($root)
	{
		$this->_root = $this->_top = $root;
		$this->_stack = array($root);
	}

	/**
	 * Inserts a node into the tree
	 *
	 * @param Node $node The node to insert
	 * @param boolean $open Whether or not to open this node to accept children
	 */
	public function insertNode($node, $open)
	{
		$this->_top->appendChild($node);
		if ($open)
		{
			$this->_top = $node;
			$this->_stack[] = $node;
		}
	}

	/**
	 * Closes the top node of the depth stack
	 *
	 * @return Node The new top node of the depth stack
	 */
	public function closeNode()
	{
		if (($c = count($this->_stack)) > 1)
		{
			$ret = array_pop($this->_stack);
			return $this->_top = $this->_stack[$c-2];
		}
	}

	/**
	 * Returns the root node
	 *
	 * @param Node
	 */
	public function getRoot()
	{
		return $this->_root;
	}
}