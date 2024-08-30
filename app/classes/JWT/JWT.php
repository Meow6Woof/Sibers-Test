<?php namespace App;

use stdClass;
/**
 * JWT
 * This class is needed to check and generate the GVT token.
 * 
 * @author Ivan Glibko 
 * @version 1.0
 */

class JWT{
    /**
     * @var string Firebase Secret Key
     * @var const Token Expires Time
     */
    private string $secretKey;
    private const EXPIRES_TIME = 7200;

    public function __construct(string $secretKey){
        $this->secretKey = $secretKey;
    }

    /**
     * Generate JWT Token
     * 
     * @param array $data
     * @return string Token
     */
    public function generateToken(array $data): string{
        $now = time();
        $payload = [
            'iat' => $now,
            'iss' => $this->getServerName(),
            'nbf' => $now,
            'exp' => $now + self::EXPIRES_TIME,
            'data' => $data,
        ];

        return \Firebase\JWT\JWT::encode($payload, $this->secretKey, 'HS256');
    }

    /**
     * Validate JWT Token
     * 
     * @param string $token
     * @return stdClass Token Data
     */
    public function validateToken(string $token): stdClass{
        try{
            return \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($this->secretKey, 'HS256'))?->data;
        } catch (\Exception $ex) {
            return new stdClass();
        }
    }

    /**
     * Get Server Name from config/project.ini
     * 
     * @return string path
     */
    private function getServerName(): string{
        $iniArray = parse_ini_file('../config/project.ini');
        $protocol = $iniArray['server_protocol'];
        $domen = $iniArray['server_domen'];
        
        return $protocol.'://'.$domen;
    }
}
?>