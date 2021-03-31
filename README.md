# Magento 2 RealThanks integration extension

## 1. How to install RealThanks integration Extension

### 1.1 Install via composer (recommend)

Run the following command in Magento 2 root folder:

```
composer require realthanks/gift-provider
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

### 1.2 Install zip package
1. Unpack the extension ZIP file on your computer.
2. Connect to your website source folder and upload all the files and folders from the extension package
   to the **app/code** folder of your Magento installation.
3. Run the following command in Magento 2 root folder:
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## 2. User Guide

The extension provides you direct gift sending from:
1. Customer grid
2. Customer form
3. Order grid
4. Order form
5. RealThanks gift grid
6. RealThanks gift order grid (re-send if a previous attempt failed)


### 2.1 How to config RealThanks integration Extension

Be sure you’re at Admin Panel.
1. Go to `Marketing > RealThanks > Settings`.
2. On the API section choose Yes to enable the extension.
3. Put your API key that you generated on RealThanks account.
4. Clear the cache

### 2.2 Data exchange with a RealThanks account 
The extension exchanges next data types:
1. Gift order. It creates by extension every time when user send a gift. Created gift order send to a user RealThanks account
2. Gifts. The extension get the last version of gifts data from account. It can be run manually or by schedule.
3. Gift order. The extension get the last version of gift order statuses. It can be run manually or by schedule.
4. Account balance. The extension get the last balance value for a user account. It performs every time when a user successfully send a gift. Also, can be run manually or by schedule.

For the **manual** update, go to `Marketing > RealThanks > Settings`. And press "Update RealThanks data".
To configure **asynchronicity** updating, please put your schedule to the 
`Marketing > RealThanks > Settings > Synchronization > Cron schedule`.
