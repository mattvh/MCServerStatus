<?php

namespace Minecraft;

class Formatting
{
	private static function foregroundColorCodeToHex( $color )
	{
		$foregroundColor = array(	'0' => "000000", '1' => "0000AA", '2' => "00AA00", '3' => "00AAAA",
									'4' => "AA0000", '5' => "AA00AA", '6' => "FFAA00", '7' => "AAAAAA",
									'8' => "555555", '9' => "5555FF", 'a' => "55FF55", 'b' => "55FFFF",
									'c' => "FF5555", 'd' => "FF55FF", 'e' => "FFFF55", 'f' => "FFFFFF" );
		return $foregroundColor[$color];
	}

	private static function backgoundColorCodeToHex( $color )
	{
		$backgroundColor= array(	'0' => "000000", '1' => "00002A", '2' => "002A00", '3' => "002A2A",
									'4' => "2A0000", '5' => "2A002A", '6' => "2A2A00", '7' => "2A2A2A",
									'8' => "151515", '9' => "15153F", 'a' => "153F15", 'b' => "153F3F",
									'c' => "3F1515", 'd' => "3F153F", 'e' => "3F3F15", 'f' => "3F3F3F" );
		return $backgroundColor[$color];
	}

	private static function formatStyle( $style )
	{
		switch( $style )
		{
			case "k": return "";								// obfuscated
			case "l": return "font-weight:bold;";				// bold
			case "m": return "text-decoration:line-through";	// strikethrough
			case "n": return "text-decoration:underline";		// underline
			case "o": return "font-style:italic";				// italic
		}
	}

	private static function formatStart( $fgColor, $bgColor, $style )
	{
		$result = "";
		if ($fgColor != null)	{ $result .= "color: #".Formatting::foregroundColorCodeToHex($fgColor).";"; }
		if ($bgColor != null)	{ $result .= "background-color: #".Formatting::backgoundColorCodeToHex($bgColor).";"; }
		if ($style != null)		{ $result .= Formatting::formatStyle($style); }

		return "<span style=\"".$result."\">";
	}

	private static function formatEnd()
	{
		return "</span>";
	}

	private static function isColorChar( $char )
	{
		return (($char >= '0' && $char <= '9') || ($char >= 'a' && $char <= 'f'));
	}

	private static function isStyleChar( $char )
	{
		return ($char >= 'k' && $char <= 'o');
	}

	// Note: does not support obfuscated style
	public static function  formatText( $text )
	{
		$fgColor = null;
		$bgColor = null;
		$format = null;

		$parsing = false;
		$previousFormatChar = null;
		$inStyle = false;

		$result = "";

		for ($idxChar = 0; $idxChar < strlen($text); $idxChar++)
		{
			$char = $text[$idxChar];
			if ($char == "\xA7") // Check for section sign
			{
				if ($inStyle)
				{
					// Close previos styling
					$result .= Formatting::formatEnd();
					$inStyle = false;
				}
				$previousFormatChar = null;
				$parsing = true;
			}
			else if ($parsing)
			{
				$validChar = false;
				if (Formatting::isColorChar($char))
				{
					// Valid color
					if ($previousFormatChar == null)
					{
						$fgColor = $char;
						$validChar = true;
					}
					else if (Formatting::isColorChar($previousFormatChar))
					{
						$bgColor = $char;
						$validChar = true;
					}
					else
					{
						$validChar = false;
					}
				}
				else if (Formatting::isStyleChar($char))
				{
					// Valid style
					if ($previousFormatChar == null)
					{
						$format = $char;
						$validChar = true;
					}
					else
					{
						$validChar = false;
					}
				}
				else if ($char == 'r')
				{
					// Reset
					$validChar = true;

					$fgColor = null;
					$bgColor = null;
					$format = null;

					if ($inStyle)
					{
						$result .= Formatting::formatEnd();
					}
					$inStyle = false;
				}

				if ($validChar)
				{
					$previousFormatChar = $char;
				}
				else
				{
					if ($fgColor != null || $bgColor != null || $format != null)
					{
						$result .= Formatting::formatStart($fgColor, $bgColor, $format);
						$inStyle = true;
					}
					$parsing = false;
					$previousFormatChar = null;
					$result .= $char;
				}
			}
			else
			{
				$result .= $char;
			}
		}
		if ($inStyle)
		{
			// Close previos styling
			$result .= Formatting::formatEnd();
			$inStyle = false;
		}

		return $result;
	}
}