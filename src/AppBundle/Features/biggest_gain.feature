Feature: Biggest gain
    In order to get information about best days for investment
    As an Investor
    I want to get biggest gain details

    Scenario: Biggest gain for money investment
        Given There are gold prices in database:
            | orm_price | orm_date   |
            | 1.00      | 2014-01-01 |
            | 2.00      | 2014-01-02 |
            | 3.00      | 2014-01-03 |
            | 1.44      | 2015-01-04 |
            | 1.77      | 2016-01-05 |
            | 1.80      | 2016-01-06 |
        When I run command "app.command.gold_prices.biggest_gain"
        Then I should see command response 'You can earn "1,200,000.00" PLN if you buy on "2014-01-01" and sell on "2014-01-03"'

    Scenario: Smallest lost for money investment
        Given There are gold prices in database:
            | orm_price | orm_date   |
            | 4.00      | 2014-01-01 |
            | 3.00      | 2014-01-02 |
            | 1.00      | 2014-01-03 |
        When I run command "app.command.gold_prices.biggest_gain"
        Then I should see command response 'You can earn "-600,000.00" PLN if you buy on "2014-01-01" and sell on "2014-01-02"'

    Scenario: Calculating biggest investment without data
        When I run command "app.command.gold_prices.biggest_gain"
        Then I should see command response 'You can earn "0.00" PLN if you buy on "not enough data" and sell on "not enough data"'
