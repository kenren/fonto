<?php
/**
 * Fonto Framework
 *
 * @author Kenny Damgren <kenny.damgren@gmail.com>
 */

namespace Fonto\Core;

class FontoException extends \Exception
{
	/**
	 * Take care of an thrown exception and displays it
	 *
	 * @param Exception $e
	 */
	public static function handle(\Exception $e)
	{
		echo "<html><div style='width:360;margin:0 auto;'><h1 style='color:red;'>Error!</h1>
			  <h2>Problem</h2>
			  <pre>{".$e->getCode()."}  ".$e->getMessage()."</pre>
			  <h2>Where</h2>
			  <pre>".$e->getFile().": Line: ".$e->getLine()."</pre>
			  <h3>Fix or become an alien!</h3></div></html>";
	}
}