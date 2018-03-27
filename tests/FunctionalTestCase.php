<?php

namespace Test;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\authentication\JwtServiceAccountFactory;
use Audiens\DoubleclickClient\authentication\Oauth2ServiceAccountStrategy;
use Audiens\DoubleclickClient\entity\ServiceAccount;
use Audiens\DoubleclickClient\service\Report;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserList;
use Audiens\DoubleclickClient\service\UserListClientService;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\FilesystemCache;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class FunctionalTestCase extends TestCase
{

    public const REQUIRED_ENV
        = [
            'SA_PRIVATE_KEY',
            'SA_CLIENT_EMAIL',
            'SA_SUBJECT',
            'CUSTOMER_ID',
        ];

    protected function setUp()
    {
        if (!$this->checkEnv()) {
            $this->markTestSkipped('cannotInitialize enviroment tests will be skipped');
        }

        parent::setUp();

        $loader = include __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);
    }

    private function checkEnv(): bool
    {
        try {
            $dotenv = new Dotenv(__DIR__.'/../');
            $dotenv->load();
        } catch (\Exception $e) {
        }

        $env = true;

        foreach (self::REQUIRED_ENV as $requiredEnv) {
            if (!getenv($requiredEnv)) {
                $env = false;
            }
        }

        return $env;
    }

    protected function buildOauth2ServiceAccountStrategy($cacheToken = true): Oauth2ServiceAccountStrategy
    {
        $cache = $cacheToken ? new FilesystemCache('cache') : null;

        $client = new Client();

        $privateKey = str_replace('\n', "\n", getenv('SA_PRIVATE_KEY'));
        $privateKey = str_replace('\'', '', $privateKey);

        $serviceAccount = new ServiceAccount(
            $privateKey,
            getenv('SA_CLIENT_EMAIL'),
            getenv('SA_SUBJECT')

        );

        $jwtFactory = new JwtServiceAccountFactory($serviceAccount);

        $authStrategy = new Oauth2ServiceAccountStrategy($client, $cache, $jwtFactory);

        return $authStrategy;
    }

    protected function buildAuth($cacheToken = true): Auth
    {
        $authStrategy = $this->buildOauth2ServiceAccountStrategy($cacheToken);

        $auth = new Auth(new Client(), $authStrategy);

        return $auth;
    }

    protected function buildReport($cacheToken = true): Report
    {
        $cache = $cacheToken ? new FilesystemCache('cache') : null;

        $report = new Report($this->buildAuth(), new TwigCompiler(), $cache);

        return $report;
    }

    /**
     * @param bool $cacheToken
     *
     * @return UserList
     */
    protected function buildUserList($cacheToken = true): UserList
    {
        $cache = $cacheToken ? new FilesystemCache('cache') : null;

        $userList = new UserList($this->buildAuth(), new TwigCompiler(), $cache, getenv('CUSTOMER_ID'));

        return $userList;
    }

    protected function buildUserClientList($cacheToken = true)
    {
        $cache = $cacheToken ? new FilesystemCache('cache') : null;

        $userClientList = new UserListClientService($this->buildAuth(), $cache, new TwigCompiler(), getenv('CUSTOMER_ID'));

        return $userClientList;
    }

}
