<?php

namespace Test;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\authentication\JwtServiceAccountFactory;
use Audiens\DoubleclickClient\authentication\Oauth2ServiceAccountStrategy;
use Audiens\DoubleclickClient\entity\ServiceAccount;
use Audiens\DoubleclickClient\service\Report;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserList;
use Doctrine\Common\Cache\FilesystemCache;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Prophecy\Argument;

/**
 * Class FunctionalTestCase
 */
class FunctionalTestCase extends TestCase
{

    const REQUIRED_ENV = [
        'SA_PRIVATE_KEY',
        'SA_CLIENT_EMAIL',
        'SA_SUBJECT',
        'CUSTOMER_ID'
    ];

    protected function setUp()
    {

        if (!$this->checkEnv()) {
            $this->markTestSkipped('cannotInitialize enviroment tests will be skipped');
        }

        parent::setUp();
    }

    /**
     * @return bool
     */
    private function checkEnv()
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


    /**
     * @param bool|true $cacheToken
     *
     * @return Oauth2ServiceAccountStrategy
     */
    protected function buildOauth2ServiceAccountStrategy($cacheToken = true)
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

    /**
     * @param bool|true $cacheToken
     *
     * @return Auth
     */
    protected function buildAuth($cacheToken = true)
    {
        $authStrategy = $this->buildOauth2ServiceAccountStrategy($cacheToken);

        $auth = new Auth(new Client(), $authStrategy);

        return $auth;
    }

    /**
     * @param bool|true $cacheToken
     *
     * @return Report
     */
    protected function buildReport($cacheToken = true)
    {
        $cache = $cacheToken ? new FilesystemCache('cache') : null;

        $report = new Report($this->buildAuth(), new TwigCompiler(), $cache);

        return $report;
    }

    /**
     * @param bool $cacheToken
     * @return UserList
     */
    protected function buildUserList($cacheToken = true)
    {
        $cache = $cacheToken ? new FilesystemCache('cache') : null;

        $userList = new UserList($this->buildAuth(), new TwigCompiler('src/action'), $cache,getenv('CUSTOMER_ID'));

        return $userList;
    }

}
