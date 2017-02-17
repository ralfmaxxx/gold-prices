# GOLD PRICES

## Requirements

You have to install vagrant [vagrant project](https://www.vagrantup.com/) and vagrant plugin:

```vagrant plugin install vagrant-hostmanager```

## How to install?

Just type:

```
vagrant up
vagrant ssh
```

And after that:

```
composer install
``` 
or
```
bin/phing install
```

For running test:

```
bin/phing
```

which consists of:

```
bin/phing quality && 
bin/phing tests
```

For importing gold prices use command:

```
bin/console app:gold_prices:importer
```

And after that run

```
bin/console app:gold_prices:biggest_gain money_to_invest
```

By default `money_to_invest` equals `600 000 PLN`. 

## Any problems?

Try to update vagrant box:

```
vagrant box update
```
