[![Build Status](https://scrutinizer-ci.com/g/christoffer-bolin/ramverk-proj/badges/build.png?b=master)](https://scrutinizer-ci.com/g/christoffer-bolin/ramverk-proj/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/christoffer-bolin/ramverk-proj/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/christoffer-bolin/ramverk-proj/?branch=master)

# Project in the course Ramverk1, BTH 2020.
Built in PHP with the framework Anax and database SQLite.

### Download and install

`git clone https://github.com/christoffer-bolin/ramverk-proj.git`

`composer install`

`make install`

`make install test`

### Create the database

`chmod 777 data`

`sqlite3 data/db.sqlite`

`chmod 666 data/db.sqlite`

`sqlite3 data/db.sqlite < sql/ddl/all_sqlite.sql`

Steps to use:

1 - Create a user
2 - Log in to user
3 - Update your profile with email, preferable joined to a gravatar
4 - Post questions, answer other questions or comment in the forum!

### Validation/tests

`make test`
