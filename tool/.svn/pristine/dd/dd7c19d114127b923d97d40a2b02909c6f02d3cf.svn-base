<?php
/**
* HtmlCompact.php
* 
* Core_HtmlCompact class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Core_HtmlCompact{
    
	public function htmlCompact($html){
		$html 	= self::remove_html_comments($html);
		$ret 	= self::_compressHorizontally($html);
		$ret 	= self::_compressVertically($ret[0], $ret[1]);
		$html 	= self::_removeSpacesInScriptAndStyleTags($ret[0]);
		
		return $html;
	}
    
    private function remove_html_comments($html = ''){
    	return preg_replace('/<!--(.|\s)*?-->/', '', $html);
    }
	
	private function _removeHtmlComments($html){
		// Check that the opening browser is internet explorer
		$msie 		= "/msie\s(.*).*(win)/i";
		$keepCond 	= (isset($_SERVER['HTTP_USER_AGENT']) && preg_match($msie, $_SERVER['HTTP_USER_AGENT']));
		if($keepCond) {
			$html = str_replace(array('<!–[if', ''), array('–**@@IECOND-OPEN@@**–', '–**@@IECOND-CLOSE@@**–'), $html);
		}
		// Remove comments
		$html = preg_replace('//', '', $html);
		// Re sub-in the conditionals if required.
		if ($keepCond) {
			$html = str_replace(array('–**@@IECOND-OPEN@@**–', '–**@@IECOND-CLOSE@@**–'), array('<!–[if', ''), $html);
		}
		return $html;
	}
	
	/**
	 * Compresses white space horizontally (ie spaces, tabs etc) whilst preserving
	 * textarea and pre content.
	 * Idea and partial code borrowed from smarty.
	 * http://smarty.net/contribs/plugins/view.php/outputfilter.trimwhitespace.php
	 *
	 * @return array
	 */
	private function _compressHorizontally($html, $preservedBlocks = false){
		$flag = true;
		if (!$preservedBlocks) {
			$flag = false;
			// Get the textarea matches
			preg_match_all('!]*>.*?!is', $html, $preservedAreaMatch);
			$preservedBlocks = $preservedAreaMatch[0];
			// Replace the textareas inerds with markers
			$html = preg_replace('!]*>.*?!is', '@@@HTMLCOMPRESSION@@@', $html);
		}
		// Remove the white space
		$html = preg_replace('/((?)\n)[\s]+/m', '\1', $html);
		// Reinsert the textareas inners
		if ($flag) {
			foreach ($preservedBlocks as $currBlock) {
				$html = preg_replace('!@@@HTMLCOMPRESSION@@@!', $currBlock, $html, 1);
			}
		}
		return array($html, $preservedBlocks);
	}
	
	/**
	 * Compresses white space vertically (ie line breaks) whilst preserving
	 * textarea and pre content.
	 *
	 * @param mixed $preservedBlocks false if no textarea blocks have already been taken out, otherwise an array.
	 * @return array
	 */
	private function _compressVertically($html, $preservedBlocks = false){
		$flag = true;
		if (!$preservedBlocks) {
			$flag = false;
			// Get the textarea matches
			preg_match_all('!]*>.*?!is', $html, $preservedAreaMatch);
			$preservedBlocks = $preservedAreaMatch[0];
			// Replace the textareas inerds with markers
			$html = preg_replace('!]*>.*?!is', '@@@HTMLCOMPRESSION@@@', $html);
		}
		$html = str_replace("\n", '', $html);
		// Reinsert the textareas inerds
		if ($flag) {
			foreach($preservedBlocks as $currBlock) {
				$html = preg_replace('!@@@HTMLCOMPRESSION@@@!', $currBlock, $html, 1);
			}
		}
		return array($html, $preservedBlocks);
	}
	
	private function _removeSpacesInScriptAndStyleTags($html) {
		preg_match_all('!(]*>(?:\\s*\\s*)?)!is', $html, $scripts);
		// Collect and compress the parts
		$compressed = array();
		$parts 		= array();
		for ($i = 0; $i < count($scripts[0]); $i++) {
			array_push($parts, $scripts[0][$i]);
			array_push($compressed, self::_removeSpacesInJsAndCss($scripts[0][$i]));
		}
		
		// Do the replacements and return
		$html = str_replace($parts, $compressed, $html);
		return $html;	
	}
	
	private function _removeSpacesInJsAndCss($code) {
		// Remove multiline comment
		$mulLineComment = '/\/\*(?!-)[\x00-\xff]*?\*\//';
		$code 			= preg_replace($mulLineComment, '', $code);
		
		// Remove single line comment
		$singLineComment 	= '/[^:]\/\/.*/';
		$code 				= preg_replace($singLineComment, '', $code);
		
		// Remove extra spaces
		$extraSpace = '/\s+/';
		$code 		= preg_replace($extraSpace, ' ', $code);
		
		// Remove spaces that can be removed
		$removableSpace = '/\s?([\{\};\=\(\)\\\/\+\*-])\s?/';
		$code 			= preg_replace('/\s?([\{\};\=\(\)\/\+\*-])\s?/', '\\1', $code);
		
		return $code;
	}
}
