<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-9-9
 * Time: 上午12:20
 */
namespace Hycooc\QyWechat\Encryption;

use Hycooc\QyWechat\Core\Exception as CoreException;

/**
 * Class EncryptionException.
 */
class EncryptionException extends CoreException
{
    const ERROR_INVALID_SIGNATURE = -40001; // Signature verification failed
    const ERROR_PARSE_XML = -40002; // Parse XML failed
    const ERROR_CALC_SIGNATURE = -40003; // Calculating the signature failed
    const ERROR_INVALID_AESKEY = -40004; // Invalid AESKey
    const ERROR_INVALID_APPID = -40005; // Check AppID failed
    const ERROR_ENCRYPT_AES = -40006; // AES Encryption failed
    const ERROR_DECRYPT_AES = -40007; // AES decryption failed
    const ERROR_INVALID_XML = -40008; // Invalid XML
    const ERROR_BASE64_ENCODE = -40009; // Base64 encoding failed
    const ERROR_BASE64_DECODE = -40010; // Base64 decoding failed
    const ERROR_XML_BUILD = -40011; // XML build failed
}
