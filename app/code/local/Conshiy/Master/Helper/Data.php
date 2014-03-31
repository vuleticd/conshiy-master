<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Conshiy
 * @package     Conshiy_Master
 * @copyright   Copyright (c) 2014 a356 Development (http://www.a356dev.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Conshiy_Master_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function encDec($Str_Message) {
		$Len_Str_Message = STRLEN ( $Str_Message );
		$Str_Encrypted_Message = "";
		for($Position = 0; $Position < $Len_Str_Message; $Position ++) {
			$Key_To_Use = (($Len_Str_Message + $Position) * 3); // (+5 or *3 or ^2)
			$Key_To_Use = (255 + $Key_To_Use) % 255;
			$Byte_To_Be_Encrypted = SUBSTR ( $Str_Message, $Position, 1 );
			$Ascii_Num_Byte_To_Encrypt = ORD ( $Byte_To_Be_Encrypted );
			$Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use; //xor operation
			$Encrypted_Byte = CHR ( $Xored_Byte );
			$Str_Encrypted_Message .= $Encrypted_Byte;
		}
		return $Str_Encrypted_Message;
	}
}