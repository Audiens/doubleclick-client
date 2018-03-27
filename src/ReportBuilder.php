<?php

namespace Audiens\DoubleclickClient;

use Audiens\DoubleclickClient\authentication\JwtServiceAccountFactory;
use Audiens\DoubleclickClient\authentication\Oauth2ServiceAccountStrategy;
use Audiens\DoubleclickClient\entity\ServiceAccount;
use Audiens\DoubleclickClient\service\Report;
use Audiens\DoubleclickClient\service\TwigCompiler;
use GuzzleHttp\Client;

class ReportBuilder
{

    public function getReportService($privateKey, $email, $subject, $cache = null): Report
    {
        $serviceAccount = new ServiceAccount($privateKey, $email, $subject);

        $jwtFactory = new JwtServiceAccountFactory($serviceAccount);

        $authStrategy = new Oauth2ServiceAccountStrategy(new Client(), $cache, $jwtFactory);

        $auth = new Auth(new Client(), $authStrategy);

        $report = new Report($auth, new TwigCompiler(), $cache);

        return $report;
    }
}
