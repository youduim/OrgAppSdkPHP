<?php

/**
 * 发送给企业应用的消息加解密、文件上传下载示例代码.
 *
 * @copyright Copyright (c) xinda.im
 */


include_once "Pkcs7Encoder.php";
include_once "ErrorCode.php";
include_once "HttpUtils.php";

/**
 * 1. 第三方回复加密消息给企业应用；
 * 2. 第三方收到企业应用发送的消息，验证消息的安全性，并对消息进行解密。
 * 3. 上传文件
 * 4. 下载文件
 */
class YdApi
{
	private $accessToken;
	private $aeskey;
	private $appId;
	private $buin;
	private $http;

	/**
	 * 构造函数
	 * @param $accessToken string 开发者设置的accessToken
	 * @param $encodingAesKey string 开发者设置的EncodingAESKey
	 * @param $AppId string 企业应用的AppId
	 * @param $Buin int 企业号
	 */
	public function YdApi($aeskey = '', $appId = '', $buin = 0)
	{
		if ($aeskey) {
			$this->aeskey = $aeskey;
		}
		if ($appId) {
			$this->appId = $appId;
		}
		if ($buin) {
			$this->buin = $buin;
		}
		$this->http = new HttpUtils;
	}

	/**
	 * 构造post参数
	 * @param $encrypt string 加密的消息体
	 */
	public function getParam($encrypt = '')
	{
		return ["buin" => $this->buin, "appId" => $this->appId, "encrypt" => $encrypt];
	}

	/**
	 * 构造post 的url
	 * @param $url string 应用API地址
	 */
	public function getTokenUrl($url = '', $param = [], $method)
	{
		$u = $url . '?accessToken='. $this->accessToken;
		if ($method != 'post') {
			foreach($param as $k => $v) {
				$u .= "&$k=$v";
			}
		}
		echo '<br>';
		echo $u;
		echo '<br>';
		return $u;
	}

	/**
	 * 获取 accessToken
	 *
	 * @param $url string 应用API地址
	 * @param $encrypt_msg string 加密消息体
	 *
	 * @return  array
	 * array[0] int 成功0，失败返回对应的错误码
	 */
	public function GetToken($url, $encrypt_msg)
	{
		$param = $this->getParam($encrypt_msg);
		$rsp = $this->http->Post($url, $param);
		$body = json_decode($rsp['body'], true);
		if ($body['errcode'] == 0) {
			list($errcode, $tk) = $this->DecryptMsg($body['encrypt']);
			if ($errcode !== 0) {
				return [ErrorCode::$DecryptAESError, ''];
			}
			$m = json_decode($tk);
			$this->accessToken = $m->accessToken;
			return [ErrorCode::$OK, $m->accessToken];
		}
		return [$body->errcode, $body->errmsg];
	}

	/**
	 * 调用API
	 *
	 * <ol>
	 *    <li>提交curl</li>
	 * </ol>
	 * @param $url string 应用API地址
	 * @param $encrypt string 加密消息体
	 * @param $encrypt_file string 加密的文件内容
	 *
	 * @return  array
	 * array[0] int 返回后台返回的错误码
	 * array[1] string 返回后台返回的错误信息
	 */
	public function Submit($url, $param, $method = 'post')
	{
		list($errcode, $encrypt) = $this->EncryptMsg(json_encode($param));
		if ($errcode !== 0) {
			return [$errcode, "加密失败"];
		}
		$curl_param = $this->getParam($encrypt);
		$u = $this->getTokenUrl($url, $param, $method);
		$rsp = $this->http->Post($u, $curl_param, $method);
		if ($rsp['httpCode'] == 200) {
			$body = json_decode($rsp['body'], true);
			if ($body['encrypt']) {
				list($errcode, $dec) = $this->DecryptMsg($body['encrypt']);
				if ($errcode !== 0) {
					$body['decrypt'] = -1;
				} else {
					$body['decrypt'] = json_decode($dec);
				}
			}
			return $body;
		} else {
			return ["errcode"=>ErrorCode::$IllegalHttpReq, "errmsg"=>"http request code ".$rsp['httpCode']];
		}
	}

	/**
	 * 解析 curl response 的 header 信息，解析成数组
	 * <ol>
	 *    <li>对header进行解析</li>
	 * </ol>
	 *
	 * @param $header string header信息
	 *
	 * @return array 
	 */
	public function decodeHeader($header)
	{
		$result = [];
		$hs = explode("\n", $header);
		for($i = 0; $i < count($hs); $i++){
			$t = explode(":", $hs[$i]);
			if($t[0] != '' && $t[1] != ''){
				$result[$t[0]] = $t[1];
			}
		}
		return $result;
	}
	
	/**
	 * 将 CURL RESPONSE 得到的文件内容保存成文件
	 * <ol>
	 *    <li>保存文件</li>
	 * </ol>
	 *
	 * @param $fileContent string 内容主体
	 * @param $filePath string 文件保存路径
	 * @param $fileName string 文件名称
	 *
	 */
	public function SaveFile($fileContent, $filePath, $fileName)
	{
		$file = fopen(iconv("UTF-8", "GBK", $filePath.$fileName), "w") or die("Unable to open file!");
		fwrite($file, $fileContent);
		fclose($file);
	}


	
	/**
	 * 将企业应用回复用户的消息加密打包.
	 * <ol>
	 *    <li>对要发送的消息进行AES-CBC加密</li>
	 * </ol>
	 *
	 * @param $msg string 企业应用待回复用户的消息
	 *
	 * @return array 
	 * array[0] int 成功0，失败返回对应的错误码
	 * array[1] string 成功返回明文，失败返回空字符串
	 */
	public function EncryptMsg($msg)
	{
		$pc = new Prpcrypt($this->aeskey);
		$result = $pc->encrypt($msg, $this->appId);
		if ($result[0] != 0) {
			return array($result[0], $result[1]);
		}
		return array(ErrorCode::$OK, $result[1]);
	}


	/**
	 * <ol>
	 *    <li>对消息进行解密</li>
	 * </ol>
	 *
	 * @param $encrypt 密文
	 *
	 * @return array 
	 * array[0] int 成功0，失败返回对应的错误码
	 * array[1] string 成功返回明文，失败返回空字符串
	 */
	public function DecryptMsg($encrypt)
	{
		if (strlen($this->aeskey) != 44) {
			return ErrorCode::$IllegalAesKey;
		}

		$pc = new Prpcrypt($this->aeskey);
		$result = $pc->decrypt($encrypt, $this->appId);
		if ($result[0] != 0) {
			return array($result[0], '');
		}

		return array(ErrorCode::$OK, $result[1]);
	}

}
