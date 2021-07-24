<?
use Ekapusta\OAuth2Esia\Provider\EsiaProvider;
use Ekapusta\OAuth2Esia\Security\JWTSigner\OpenSslCliJwtSigner;
use Ekapusta\OAuth2Esia\Security\Signer\OpensslPkcs7;


$provider = new EsiaProvider([
    'clientId'      => 'XXXXXX',
    'redirectUri'   => 'https://your-system.domain/auth/finish/',
    'defaultScopes' => ['openid', 'fullname', '...'],
// For work with test portal version
//  'remoteUrl' => 'https://esia-portal1.test.gosuslugi.ru',
//  'remotePublicKey' => EsiaProvider::RESOURCES.'esia.test.public.key',
// For work with GOST3410_2012_256 signatures (instead of default RS256)
//  'remoteCertificatePath' => EsiaProvider::RESOURCES.'esia.gost.prod.public.key',
], [
    'signer' => new OpensslPkcs7('/path/to/public/certificate.cer', '/path/to/private.key'),
// For work with GOST3410_2012_256 signatures (instead of default RS256)
//    'remoteSigner' => new OpenSslCliJwtSigner('/path/to/openssl'),
]);