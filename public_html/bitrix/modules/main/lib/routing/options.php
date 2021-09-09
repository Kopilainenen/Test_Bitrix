<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage main
 * @copyright  2001-2020 Bitrix
 */

namespace Bitrix\Main\Routing;

/**
 * @package    bitrix
 * @subpackage main
 */
class Options
{
	// could be auto-generated by Reflection and prop-prefixes
	public static $optionList = [
		'methods', 'middleware', 'prefix', 'name', 'domain', 'where', 'default'
	];

	protected $methods = [];

	protected $middleware = [];

	protected $prefix;

	protected $parentPrefixes = [];

	protected $name;

	protected $parentNames = [];

	protected $domain;

	protected $where = [];

	protected $default = [];

	/**
	 * @param Options $anotherOptions
	 */
	public function mergeWith($anotherOptions)
	{
		$this->middleware = array_merge($this->middleware, $anotherOptions->middleware);

		if ($anotherOptions->prefix != '')
		{
			$this->parentPrefixes[] = $anotherOptions->prefix;
		}

		if ($anotherOptions->name != '')
		{
			$this->parentNames[] = $anotherOptions->name;
		}
	}

	public function methods($methods)
	{
		$this->methods = $methods;
	}

	/**
	 * @return array
	 */
	public function getMethods()
	{
		return $this->methods;
	}

	public function middleware($middleware)
	{
		if (is_array($middleware))
		{
			$this->middleware = array_merge($this->middleware, $middleware);
		}
		else
		{
			$this->middleware[] = $middleware;
		}
	}

	public function prefix($prefix)
	{
		$this->prefix = $prefix;
	}

	public function hasPrefix()
	{
		return $this->prefix != '' || !empty($this->parentPrefixes);
	}

	public function getFullPrefix()
	{
		// concat parentPrefixes with this prefix
		$prefixes = $this->parentPrefixes ?: [];

		if ($this->prefix != '')
		{
			$prefixes[] = $this->prefix;
		}


		return '/'.join('/', $prefixes);
	}

	public function name($name)
	{
		$this->name = $name;
	}

	public function hasName()
	{
		return $this->name != '';
	}

	public function getFullName()
	{
		if ($this->name == '')
		{
			// route should have its own name
			return '';
		}

		// concat parentPrefixes with this prefix
		$parts = $this->parentNames ?: [];
		$parts[] = $this->name;

		return join('', $parts);
	}

	/**
	 * @param string $domain
	 */
	public function domain($domain)
	{
		$this->domain = $domain;
	}

	public function where($parameter, $pattern)
	{
		$this->where[$parameter] = $pattern;
	}

	public function hasWhere($parameter)
	{
		return array_key_exists($parameter, $this->where);
	}

	public function getWhere($parameter = null)
	{
		if ($parameter === null)
		{
			return $this->where;
		}
		else
		{
			return $this->where[$parameter];
		}
	}

	public function default($parameter, $value)
	{
		$this->default[$parameter] = $value;
	}

	public function hasDefault($parameter)
	{
		return array_key_exists($parameter, $this->default);
	}

	public function getDefault($parameter = null)
	{
		if ($parameter === null)
		{
			return $this->default;
		}
		else
		{
			return $this->default[$parameter];
		}
	}

	/**
	 * Clears runtime options for the new scope
	 * Saves global options and
	 */
	public function clearCurrent()
	{
		$this->prefix = null;
		$this->name = null;
	}
}