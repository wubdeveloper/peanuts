<?php
/**
 * Peanuts (http://peanuts.wubbobos.nl/)
 *
 * @link      http://github.com/wubdeveloper/peanuts for the canonical source repository
 * @copyright Copyright (c) 2014 Wubbo Bos (http://www.wubbobos.nl)
 * @license   https://gnu.org/licenses/gpl.html GNU Public License
 */

namespace Peanuts\Utility\Blueprint;

class DefinitionLoader
{
	/**
	 * Creates a child node with the specified type, name and parameters
	 *
	 * @param string $type
	 * @param string $name
	 * @param string $params Comma-separated list of parameters
	 */
	protected static function _createChildNode($type, $name, $params)
	{
		$node = new Node($name);
		$node->defType = $type;

		$open = false;
		if (preg_match("/\swith$/", $params))
		{
			$params = substr($params, 0, strlen($params) - 5);
			$open = true;
		}
		$node->params = preg_split("/\s*,\s*/", trim($params));

		return $node;
	}

	/**
	 * Loads a definition file into a definition tree
	 *
	 * @param string $file The file name of the file to load
	 * @return \Peanuts\Data\Node The root definition node with its children
	 */
	public static function load($file)
	{
		if (!file_exists($file))
		{
			throw new \Exception("Could not load definitions from {$file}: file doesn't exist");
		}

		$deftree = null;

		$lines = file($file);
		foreach ($lines as $line)
		{
			$line = trim($line);
			if (preg_match("/^def\s([a-z][a-z0-9_]*)\s([a-z][a-z0-9_]*)/", $line, $m))
			{
				$node = new Node($m[2]);
				$node->defType = $m[1];
				$deftree = new Tree($node);
			}
			else if ($deftree)
			{
				if (preg_match("/^([a-z][a-z0-9_]*)\s([a-z][a-z0-9_]*)(.*)/", $line, $m))
				{
					$deftree->insertNode(
						self::_createChildNode($m[1], $m[2], isset($m[3]) ? $m[3] : '',
						$open
					);
				}
				else if ($line == "end")
				{
					$deftree->closeNode();
				}
			}
		}

		return $deftree->getRoot();
	}
}