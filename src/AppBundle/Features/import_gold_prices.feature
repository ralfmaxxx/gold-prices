Feature: Importing gold prices
    In order to take advantage of gold prices
    As a System
    I want to store all of them in database

    Scenario: Importing gold prices using command
        Given There are gold prices in API for year 2017:
            | api_price | api_date   |
            | 123.23    | 2017-01-01 |
        And There are gold prices in API for year 2016:
            | api_price | api_date   |
            | 12.23     | 2016-02-01 |
            | 2.22      | 2016-02-02 |
        And There are gold prices in API for year 2015:
            | api_price | api_date   |
            | 44.23     | 2015-01-01 |
            | 22.22     | 2015-01-02 |
        And There are gold prices in API for year 2014:
            | api_price | api_date   |
            | 1.00      | 2014-01-01 |
            | 22.00     | 2014-01-02 |
        And There are gold prices in API for year 2013:
            | api_price | api_date   |
            | 66.00     | 2013-06-01 |
        And There is no data available for year 2012
        And There is no data available for year 2011
        And There is no data available for year 2010
        And There is no data available for year 2009
        And There is no data available for year 2008
        And There is no data available for year 2007
        When I run command "app.command.gold_prices.importer"
        Then I should have 8 gold prices imported
        And I should have gold price from "2017-01-01" imported
        And I should have gold price from "2016-02-01" imported
        And I should have gold price from "2016-02-02" imported
        And I should have gold price from "2015-01-01" imported
        And I should have gold price from "2015-01-02" imported
        And I should have gold price from "2014-01-01" imported
        And I should have gold price from "2014-01-02" imported
        And I should have gold price from "2013-06-01" imported
