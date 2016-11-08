# Audiens/doubleclick-client
[![Code Climate](https://codeclimate.com/github/Audiens/doubleclick-client/badges/gpa.svg)](https://codeclimate.com/github/Audiens/doubleclick-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Audiens/doubleclick-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Audiens/doubleclick-client/?branch=master)
[![Build Status](https://travis-ci.org/Audiens/doubleclick-client.svg?branch=master)](https://travis-ci.org/Audiens/doubleclick-client)
[![Coverage Status](https://coveralls.io/repos/github/Audiens/doubleclick-client/badge.svg?branch=master)](https://coveralls.io/github/Audiens/doubleclick-client?branch=master)

An OOP implementation af the Doubleclick DDP Soap API.
    
## Installation

To use this package, use composer:

 * from CLI: `composer require Audiens/doubleclick-client`
 * or, directly in your `composer.json`:

``` 
{
    "require": {
        "Audiens/doubleclick-client": "dev-master"
    }
}
```
  
## Usage


```php

require 'vendor/autoload.php';

$privateKey = getenv('SA_PRIVATE_KEY');
$email = getenv('SA_CLIENT_EMAIL');
$subject = getenv('SA_SUBJECT');

$reportBuilder = new ReportBuilder();
$reportService = $reportBuilder->getReportService($privateKey, $email, $subject)

// Report Fetch Example

$from = new \DateTime('-10 days');
$to = new \DateTime('now');

$reportConfig = ReportConfig(
        'your_customer_id',
        'company_name',
        'company_user_agent',
        $from,
        $to
    );

$revenueList = $reportService->getRevenue($reportConfig);

foreach ($revenueList as $revenueItem) {

   echo "BUYER NAME: " $revenueItem->getClientName(). "\n"
   echo "REVENUE ($): " $revenueItem->getSegmentRevenue(). "\n"
   echo "IMPRESSION : " $revenueItem->getSegmentImpression(). "\n"

}

```

